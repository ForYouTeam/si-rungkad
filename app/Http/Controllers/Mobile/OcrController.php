<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Traits\OcrApiService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use stdClass;

class OcrController extends Controller
{
    use ApiResponse;
    use OcrApiService;

    function base64ToImage($base64String, $outputFile) {
        // Menghapus header data dari base64 string
        $base64String = preg_replace('/^data:image\/(png|jpeg|gif);base64,/', '', $base64String);
    
        // Mendekode base64 string menjadi data biner
        $imageData = base64_decode($base64String);
        $image = imagecreatefromstring($imageData);
    
        // Menentukan path untuk menyimpan file di dalam folder public/images/
        $outputPath = 'storage/images/' . $outputFile;
    
        // Menyimpan data biner ke file gambar
        if (!is_dir('storage/images/')) {
            mkdir('storage/images/', 0777, true);
        }

        imagejpeg($image, $outputPath, 70);
        imagedestroy($image);
    
        // Mengembalikan nama file hasil simpan
        return $outputPath;
    }

    public function getImageText(Request $request)
    {
        if ($this->validation($request)->fails()) return $this->error($this->validation($request)->errors()->first(), 422, $this->validation($request)->errors());

        try {
            $file = $this->base64ToImage($request->input('file'), $request->email . ".png" ?? "test.png");
            // dd(file_get_contents(public_path($file)));

            $ocrResponse = $this->ocrCall($file, $request->email . ".png");
            $ocrResponse = $ocrResponse['data']['ParsedResults'][0]['TextOverlay']['Lines'];
            $ocrResponse = $this->getKtpData($ocrResponse);
            $ocrResponse = $this->getCleanedLineTextFromIndex0($ocrResponse);
            // dd($ocrResponse);
            $person = new stdClass();
            
            $person->nik = $ocrResponse[0];
            $person->nama = $ocrResponse[2];
            $person->ttl = $ocrResponse[3];
            $person->jk = $ocrResponse[5];
            $person->alamat = $ocrResponse[7];
            
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($person, 'berhasil');
    }

    private function getKtpData($arrayData) {
        $foundArrays = [];

        // Flag untuk menandai apakah harus mencari array atau tidak
        $shouldSearch = false;

        // Loop melalui data untuk mencari informasi yang diinginkan
        foreach ($arrayData as $item) {
            // Cek apakah LineText mengandung string number
            if (preg_match('/\b\d{16}\b/', $item["LineText"])) {
                // Jika ya, atur flag agar mencari array
                $shouldSearch = true;
            }

            // Jika flag aktif, tambahkan array ke foundArrays
            if ($shouldSearch) {
                $foundArrays[] = $item;

                // Cek apakah LineText mengandung string "SEUMUR HIDUP"
                if (strpos($item["LineText"], "SEUMUR HIDUP") !== false) {
                    // Jika ya, hentikan pencarian
                    break;
                }
            }
        }
        return $foundArrays;
    }

    private function cleanAndSplitLineText($lineText) {
        // Split nilai jika terdapat simbol ":"
        $splitValues = explode(':', $lineText, 2);
    
        // Ambil data kedua setelah split (jika ada), atau ambil nilai awal
        $cleanedValue = isset($splitValues[1]) ? $splitValues[1] : $lineText;
    
        // Hilangkan semua simbol kecuali , . - _ / dan spasi
        $cleanedValue = preg_replace('/[^a-zA-Z0-9,.\s\-_\/]/', '', $cleanedValue);
    
        return $cleanedValue;
    }
    
    private function getCleanedLineTextFromIndex0($arrayData) {
        $result = [];
    
        // Loop melalui data dimulai dari indeks 0
        for ($i = 0; $i < count($arrayData); $i++) {
            // Pastikan indeks yang diakses ada dalam batas array
            if (isset($arrayData[$i]['LineText'])) {    
                // Ambil bagian LineText, bersihkan, dan tambahkan ke hasil
                $result[] = $this->cleanAndSplitLineText($arrayData[$i]['LineText']);
            }
        }
    
        return $result;
    }
    private function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'file' => 'required'
        ]);
    }
}
