<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Interfaces\ProfileInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    private ProfileInterfaces $profileRepo;

    public function __construct(ProfileInterfaces $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    public function getView()
    {
        $data = $this->profileRepo->getAllPayload([]);
        return view('pages.pasien.index')->with('data', $data['data']);
    }

    public function addView()
    {
        return view('pages.pasien.add');
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->profileRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->profileRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(ProfileRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'user_id'    => $payload->user_id,
            'nama'       => $payload->nama,
            'alamat'     => $payload->alamat,
            'no_hp'      => $payload->no_hp,
            'jk'         => $payload->jk,
            'email'      => $payload->email,
            'pekerjaan'  => $payload->pekerjaan,
            'status'     => $payload->status,
            'tgl_lahir'  => $payload->tgl_lahir,
            'agama'      => $payload->agama,
            'created_at' => $date,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->profileRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->profileRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
