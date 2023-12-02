<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalCardRequest;
use App\Interfaces\MedicalCardInterfaces;
use App\Interfaces\ProfileInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicalCardController extends Controller
{
    private MedicalCardInterfaces $medicalcardRepo;
    private ProfileInterfaces $profileRepo;


    public function __construct(MedicalCardInterfaces $medicalcardRepo, ProfileInterfaces $profileRepo)
    {
        $this->medicalcardRepo = $medicalcardRepo;
        $this->profileRepo = $profileRepo;
    }

    public function getView()
    {
        $data = $this->medicalcardRepo->getAllPayload([]);
        $profileid = $this->profileRepo->getAllPayload([]);
        return view('pages.MedicalCard')->with(['data'=> $data['data'], 'profileid' => $profileid['data']]);;
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->medicalcardRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->medicalcardRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(MedicalCardRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'no_rm'       => $payload->no_rm ,
            'profile_id'  => $payload->profile_id,
            'barcode'     => $payload->barcode,
            'created_at'  => $date,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->medicalcardRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->medicalcardRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
