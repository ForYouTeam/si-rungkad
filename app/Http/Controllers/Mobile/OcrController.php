<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Traits\OcrApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class OcrController extends Controller
{
    use ApiResponse;
    use OcrApiService;

    public function getImageText(Request $request)
    {
        if ($this->validation($request)->fails()) return $this->error($this->validation($request)->errors()->first(), 422, $this->validation($request)->errors());

        try {
            $ocrResponse = $this->ocrCall($request);
            $ocrResponse = $this->mapping($ocrResponse['data']['ParsedResults'][0]['TextOverlay']['Lines']);

            $person = new stdClass();
            
            foreach ($ocrResponse as $item) {
                $field = str_replace(' ', '_', strtolower($item['field'])); // Mengonversi field menjadi lowercase dan mengganti spasi dengan underscore
                $person->$field = ltrim($item['value'], ': '); // Menambahkan properti ke objek
            }
            
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($person, 'berhasil');
    }

    private function mapping(array $payload)
    {
        $filter = ['nik', 'nama', 'Tempat/Tgl Lahir', 'Jenis Kelamin', 'Alamat', 'RT/RW', 'Kel/Desa', 'Kecamatan', 'Agama', 'Pekerjaan'];

        return collect($payload)->map(function ($item, $key) use ($filter, $payload) {
            foreach ($filter as $index => $value) {
                if (strtolower($item['LineText']) === strtolower($value)) {
                    // Memastikan ada nilai selanjutnya sebelum mengaksesnya
                    if (isset($payload[$key + 1]['LineText'])) {
                        return [
                            'field' => $item['LineText'],
                            'value' => $payload[$key + 1]['LineText'],
                        ];
                    }
                }
            }
            return null;
        })->filter();
    }


    private function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
    }
}
