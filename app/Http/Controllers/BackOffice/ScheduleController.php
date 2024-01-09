<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Interfaces\PolyInterfaces;
use App\Interfaces\ScheduleInterfaces;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private ScheduleInterfaces $scheduleRepo;
    private PolyInterfaces $polyRepo;

    public function __construct(ScheduleInterfaces $scheduleRepo, PolyInterfaces $polyRepo)
    {
        $this->scheduleRepo = $scheduleRepo;
        $this->polyRepo = $polyRepo;
    }

    public function getView()
    {
        $poly = $this->polyRepo->getAllPayload([]);
        $data = $this->scheduleRepo->getAllPayload([]);
        return view('pages.Schedule')->with([
            'data' => $data['data'],
            'poly' => $poly['data']
        ]);
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

    public function upsertData(Request $request)
    {
        $date = Carbon::now();
        $schedule = array(
            'schedule_id' => $request->schedule_id ,
            'poly_id'     => $request->poly_id     ,
            'start_time'  => $request->start_time  ,
            'end_time'    => $request->end_time    ,
            'created_at'  => $date                 ,
        );


        // $detailSchedule = [

        // ];

        $response = $this->scheduleRepo->upsertPayload($schedule);

        return response()->json($response, $response['code']);
    }

    public function deleteData($idPayload)
    {
        $response = $this->scheduleRepo->deletePayload($idPayload);

        return response()->json($response, $response['code']);
    }

}
