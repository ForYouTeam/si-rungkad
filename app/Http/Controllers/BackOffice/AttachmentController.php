<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttacmentRequest;
use App\Interfaces\AttachmentInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    private AttachmentInterfaces $attachmentRepo;

    public function __construct(AttachmentInterfaces $attachmentRepo)
    {
        $this->attachmentRepo = $attachmentRepo;
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->attachmentRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->attachmentRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(AttacmentRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'foto_ktp'             => $payload->foto_ktp ,
            'foto_kartu_berobat'   => $payload->foto_kartu_berobat,
            'created_at' => $date          ,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->attachmentRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->attachmentRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
