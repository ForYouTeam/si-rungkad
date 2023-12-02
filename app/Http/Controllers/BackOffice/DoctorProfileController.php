<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProfileRequest;
use App\Interfaces\DoctorProfileInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    private DoctorProfileInterfaces $doctorprofileRepo;

    public function __construct(DoctorProfileInterfaces $doctorprofileRepo)
    {
        $this->doctorprofileRepo = $doctorprofileRepo;
    }

    public function getView()
    {
        $data = $this->doctorprofileRepo->getAllPayload([]);
        return view('pages.DoctorProfile')->with('data', $data['data']);
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->doctorprofileRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->doctorprofileRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(DoctorProfileRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'user_id'    => $payload->user_id ,
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

        $response = $this->doctorprofileRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->doctorprofileRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
