<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait OcrApiService {

    protected $ocrUrl = '';
    
    public function ocrCall(Request $request) {
        try {
            $this->ocrUrl = config('ocr.url');
            
            $response = Http::withHeaders([
                'apiKey'    => config('ocr.apikey')
            ])
            ->attach(
                'file',  // Nama field file
                file_get_contents($request->file('file')->path()),  // Isi file
                $request->file('file')->getClientOriginalName()  // Nama file yang akan ditampilkan di server
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