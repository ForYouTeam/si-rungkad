<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Interfaces\ScheduleInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private ScheduleInterfaces $scheduleRepo;

    public function __construct(ScheduleInterfaces $scheduleRepo)
    {
        $this->scheduleRepo = $scheduleRepo;
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->scheduleRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->scheduleRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(ScheduleRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'poly_id'       => $payload->poly_id ,
            'doctor_id'     => $payload->doctor_id,
            'tgl'           => $payload->tgl,
            'jam_praktek'   => $payload->jam_praktek,
            'created_at'    => $date          ,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->scheduleRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->scheduleRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
