<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttacmentRequest;
use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\ProfileInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $date = Carbon::now()->format('Y-m-d H-i');
        $file1      = $payload->file('foto_ktp');
        $filename1  = $date .$file1->getClientOriginalName();
        $filePath1  = storage_path('app/public/image');
        $file1->move($filePath1, $filename1);

        $file2      = $payload->file('foto_kartu_berobat');
        $filename2  = $date .$file2->getClientOriginalName();
        $filePath2  = storage_path('app/public/image');
        $file2->move($filePath2, $filename2);
        
        $payload = array(
            'foto_ktp'           => $filename1            ,
            'foto_kartu_berobat' => $filename2            ,
            'user_id'            => 1    ,
            'profile_id'         => $payload->profile_id    ,
            'created_at'         => $date                 ,
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
