<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

trait OcrApiService {

    protected $ocrUrl = '';
    
    public function ocrCall(mixed $request, string $fileName) {
        try {
            $this->ocrUrl = config('ocr.url');
            
            $response = Http::timeout(120)->withHeaders([
                'apiKey'    => config('ocr.apikey')
            ])
            ->attach(
                'file',  // Nama field file
                file_get_contents(public_path($request)),  // Isi file
                $fileName // Nama file yang akan ditampilkan di server
            )->post($this->ocrUrl, [
                'OCREngine' => config('ocr.OCREngine')
            ]);

            return [
                'message' => 'success',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'data' => null
            ];
        }
    }
}