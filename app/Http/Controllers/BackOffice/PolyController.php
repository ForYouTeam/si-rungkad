<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolyRequest;
use App\Interfaces\PolyInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PolyController extends Controller
{
    private PolyInterfaces $polyRepo;

    public function __construct(PolyInterfaces $polyRepo)
    {
        $this->polyRepo = $polyRepo;
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->polyRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->polyRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(PolyRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $payload = array(
            'nama'             => $payload->nama ,
            'ruangan'            => $payload->ruangan,
            'jam_praktek'      => $payload->jam_praktek,
            'created_at' => $date          ,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->polyRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->polyRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
