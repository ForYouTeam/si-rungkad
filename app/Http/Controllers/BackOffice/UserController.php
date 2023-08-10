<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserInterfaces $userRepo;

    public function __construct(UserInterfaces $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getAllData(): JsonResponse
    {
        $response = $this->userRepo->getAllPayload([]);

        return response()->json($response, $response['code']);
    }

    public function getDataById($idPayload)
    {
        $response = $this->userRepo->getPayloadById($idPayload);

        return response()->json($response, $response['code']);
    }

    public function upsertData(UserRequest $payload)
    {
        $idPayload = $payload->id | null;

        $date = Carbon::now();
        $hash = Hash::make($payload['password']);
        $payload = array(
            'nama'       => $payload->nama ,
            'username'   => $payload->username,
            'password'   => $hash,
            'scope'      => $payload->scope,
            'created_at' => $date,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->userRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->userRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }
}
