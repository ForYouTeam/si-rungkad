<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberRegistrationController extends Controller
{
    use ApiResponse;
    public function __construct(protected Request $request)
    {
        
    }

    public function saveFile(Request $request)
    {
        // Mendapatkan NIK dari request
        $nik = $request->nik;
        $file = $request->file('file');

        if ($this->validation($request)->fails()) return $this->error('Permintaan data tidak dapat diproses', 422, $this->validation($request)->errors());

        if (!$file) {
            return $this->error('File not exist', 422);
        }

        try {
            DB::beginTransaction();
            $user = array(
               'nama'     => $request->nama,
               'email'    => $request->email,
               'scope'    => 'pasien',
               'password' => $request->password 
            );

            $userResult = $this->createUser($user);

            $profile = array(
                'no_rm'           => $this->createNoRm(),
                'nik'             => $request->nik,
                'nama'            => $request->nama,
                'alamat'          => $request->alamat,
                'jk'              => $request->jk,
                'status_nikah'    => $request->status_nikah,
                'agama'           => $request->agama,
                'pekerjaan'       => $request->pekerjaan,
                'kewarganegaraan' => $request->kewarganegaraan,
                'verified'        => false,
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
                'user_id'         => $userResult->id
            );

            $profileResult = Profile::create($profile);

            $this->saveFileFromForm($file, $nik, $profileResult);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 500);
        }
        DB::commit();
        return $this->success(null, "You are registered successfully");
    }

    private function saveFileFromForm($file, $nik, $profile)
    {
        $fileExtension  = $file->getClientOriginalExtension();
        $filename       = $nik . '.' . $fileExtension;
        $file->storeAs('public/file_attempt', $filename);

        Attachment::create([
            'profile_id' => $profile->id,
            'nama'       => $profile->nama,
            'path'       => 'public/file_attempt/' . $filename,
            'to_ocr'     => true
        ]);
    }

    private function createUser(array $request) {
        $result = User::create($request);
        return $result;
    }

    private function createNoRm() {
        $currentDate = date('Ymd');

        // Menghasilkan string acak dengan panjang maksimum 5 karakter
        $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);

        // Menggabungkan tanggal dan string acak
        $prefixString = $currentDate . $randomString;

        return $prefixString;
    }

    private function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'file'            => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'email'           => 'required|email|unique:user,email',
            'password'        => 'required|confirmed|min:5|max:15',
            'nik'             => 'required|min:14|max:18',
            'nama'            => 'required|min:2|max:50',
            'alamat'          => 'required|min:5',
            'jk'              => 'required',
            'agama'           => 'required',
            'status_nikah'    => 'required',
            'pekerjaan'       => 'required',
            'kewarganegaraan' => 'required',
        ]);
    }
}
