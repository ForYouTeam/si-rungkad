<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitHistoryRequest;
use App\Interfaces\VisitHistoryInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitHistoryController extends Controller
{
    private VisitHistoryInterfaces $visithistoryRepo;

    public function __construct(VisitHistoryInterfaces $visithistoryRepo)
    {
        $this->visithistoryRepo = $visithistoryRepo;
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->visithistoryRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->visithistoryRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(VisitHistoryRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'profile_id'      => $payload->profile_id ,
            'registation_id'  => $payload->registation_id ,
            'tgl_kunjungan'   => $payload->tgl_kunjungan,
            'waktu_kunjungan' => $payload->waktu_kunjungan,
            'keterangan'      => $payload->keterangan,
            'created_at'      => $date,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->visithistoryRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->visithistoryRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
