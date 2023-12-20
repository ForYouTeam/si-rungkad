<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProfileRequest;
use App\Interfaces\DoctorProfileInterfaces;
use App\Interfaces\PolyInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    private DoctorProfileInterfaces $doctorprofileRepo;
    private PolyInterfaces $poliRepo;

    public function __construct(DoctorProfileInterfaces $doctorprofileRepo, PolyInterfaces $poliRepo)
    {
        $this->doctorprofileRepo = $doctorprofileRepo;
        $this->poliRepo = $poliRepo;
    }

    public function getView()
    {
        
        $poly = $this->poliRepo->getAllPayload([]);
        $dokter = $this->doctorprofileRepo->getAllPayload([]);
        return view('pages.dokter.index')->with([
            'dokter' => $dokter['data'],
            'poly' => $poly['data']
        ]);
    }

    public function addView()
    {
        $poly = $this->poliRepo->getAllPayload([]);
        return view('pages.dokter.add')->with('poly', $poly['data']);
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
            'user_id'    => 1                 ,
            'nama'       => $payload->nama    ,
            'alamat'     => $payload->alamat  ,
            'nip'        => $payload->nip     ,
            'jk'         => $payload->jk      ,
            'jurusan'    => $payload->jurusan ,
            'poly_id'    => $payload->poly_id ,
            'agama'      => $payload->agama   ,
            'created_at' => $date             ,
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
