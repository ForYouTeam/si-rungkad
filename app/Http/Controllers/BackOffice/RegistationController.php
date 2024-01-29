<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistationRequest;
use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\MedicalCardInterfaces;
use App\Interfaces\PolyInterfaces;
use App\Interfaces\ProfileInterfaces;
use App\Interfaces\RegistationInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistationController extends Controller
{
    private RegistationInterfaces $registationRepo;
    private ProfileInterfaces $profileRepo;

    public function __construct(RegistationInterfaces $registationRepo, ProfileInterfaces $profileRepo)
    {
        $this->registationRepo = $registationRepo;
        $this->profileRepo = $profileRepo;
    }

    public function getView()
    {
        $prfoile = $this->profileRepo->getAllPayload([]); 
        $data = $this->registationRepo->getAllPayload([]);
        return view('pages.registrasi.index')->with(['data' => $data['data'], 'profile' => $prfoile['data']]);
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

    public function upsertData(Request $request)
    {
        $idPayload = $request->id | null;
        $date = Carbon::now();
        $tgl = $request->tgl;
        $no_regis = "REG-". rand(1000, 9999). "_" .$tgl;

        $payload = array(
            'profile_id'    => $request->profile_id,
            'no_rm'         => $request->no_rm     ,
            'no_registrasi' => $no_regis           ,
        );

        if ($idPayload) {
            $payload['updated_at'] = $date;
        }

        $response = $this->registationRepo->upsertPayload($idPayload, $payload);

        return response()->json($response, $response['code']);
    }
}
