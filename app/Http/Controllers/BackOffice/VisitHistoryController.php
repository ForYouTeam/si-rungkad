<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitHistoryRequest;
use App\Interfaces\ProfileInterfaces;
use App\Interfaces\RegistationInterfaces;
use App\Interfaces\VisitHistoryInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitHistoryController extends Controller
{
    private VisitHistoryInterfaces $visithistoryRepo;
    private ProfileInterfaces $profileRepo;
    private RegistationInterfaces $registationRepo;

    public function __construct(VisitHistoryInterfaces $visithistoryRepo, ProfileInterfaces $profileRepo, RegistationInterfaces $registationRepo)
    {
        $this->visithistoryRepo = $visithistoryRepo;
        $this->profileRepo = $profileRepo;
        $this->registationRepo = $registationRepo;
    }

    public function getView()
    {
        $data = $this->visithistoryRepo->getAllPayload([]);
        $profileid = $this->profileRepo->getAllPayload([]);
        $registationid = $this->registationRepo->getAllPayload([]);
        return view('pages.VisitHistory')->with(['data' => $data['data'], 'profileid' => $profileid['data'], 'registationid' => $registationid['data']]);;;
    }

    public function getDetail($idPayload)
    {
        $response = $this->visithistoryRepo->getPayloadById($idPayload);
        return view('pages.registrasi.show')->with('response', $response['data']);
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
}
