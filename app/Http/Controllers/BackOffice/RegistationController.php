<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistationRequest;
use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\MedicalCardInterfaces;
use App\Interfaces\PolyInterfaces;
use App\Interfaces\RegistationInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistationController extends Controller
{
    private RegistationInterfaces $registationRepo;
    private PolyInterfaces $polyRepo;
    private AttachmentInterfaces $attachmentRepo;

    public function __construct(RegistationInterfaces $registationRepo,  PolyInterfaces $polyRepo, AttachmentInterfaces $attachmentRepo)
    {
        $this->registationRepo = $registationRepo;
        $this->polyRepo = $polyRepo;
        $this->attachmentRepo = $attachmentRepo;
    }

    public function getView()
    {
        $data = $this->registationRepo->getAllPayload([]);
        $polyid = $this->polyRepo->getAllPayload([]);
        $lampiran = $this->attachmentRepo->getAllPayload([]);
        return view('pages.Registation')->with(['data' => $data['data'], 'polyid' => $polyid['data'], 'lampiran' => $lampiran['data']]);
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->registationRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->registationRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(RegistationRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'no_registrasi'     => $payload->no_registrasi ,
            'medicalcard_id'    => $payload->medicalcard_id ,
            'poly_id'           => $payload->poly_id,
            'tgl_registrasi'    => $payload->tgl_registrasi,
            'attachment_id'     => $payload->attachment_id,
            'qr_code'           => $payload->qr_code,
            'created_at'        => $date          ,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->registationRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->registationRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
