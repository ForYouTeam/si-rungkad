<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttacmentRequest;
use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\ProfileInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AttachmentController extends Controller
{
    private AttachmentInterfaces $attachmentRepo;
    private ProfileInterfaces $profileInterface;

    public function __construct(AttachmentInterfaces $attachmentRepo, ProfileInterfaces $profileInterface)
    {
        $this->attachmentRepo = $attachmentRepo;
        $this->profileInterface = $profileInterface;
    }

    public function getView()
    {
        $data = $this->attachmentRepo->getAllPayload([]);
        $pasien = $this->profileInterface->getAllPayload([]);
        return view('pages.Attachment')->with([
            'data' => $data['data'],
            'pasien' => $pasien['data']
        ]);
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

        $date = Carbon::now()->format('H-i');
        $file1      = $payload->file('path');
        $filename1  = $date .$file1->getClientOriginalName();
        $filePath1  = storage_path('app/public/image');
        $file1->move($filePath1, $filename1);
        
        $payload = array(
            'path'       => $filename1           ,
            'nama'       => $payload->nama       ,
            'profile_id' => $payload->profile_id ,
            'to_ocr'     => 1                    ,
            'created_at' => $date                ,
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
