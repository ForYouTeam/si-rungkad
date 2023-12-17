<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\schedule;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    use ApiResponse;

    public function getList(Request $request) {

        try {
            $listData = new schedule();
            $listData = $listData->query()
                ->joinListMobile()
                ->when($request->doctor_id, function($query) use ($request) {
                    return $query
                        ->where('schedule.dokter_id', $request->doctor_id);
                })
                ->when($request->today, function($query) use ($request) {
                    return $query
                        ->where('schedule.tgl', $request->today);
                })
                ->get();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
