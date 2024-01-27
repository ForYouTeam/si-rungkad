<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberRegistrationController extends Controller
{
    use ApiResponse;
    public function __construct(protected Request $request)
    {
        
    }

    public function __invoke()
    {
        $this->saveFile($this->request);
    }

    private function saveFile(Request $request)
    {
        // Mendapatkan NIK dari request
        $nik = $request->input('nik');
        $file = $request->file('file');

        if (!$file) {
            return $this->error('File not exist', 422);
        }

        try {
            $this->saveFileFromForm($file, $nik);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
        return $this->success(null, "File saved successfully");
    }

    private function saveFileFromForm($file, $nik)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $filename = $nik . $fileExtension;
        $file->storeAs('public/file_attempt', $filename);
    }
}
