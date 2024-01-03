<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\DetailSchedule;
use App\Models\Schedule;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    use ApiResponse;

    public function getList(Request $request) {

        try {
            $listData = new DetailSchedule();
            $listData = $listData
                ->query()
                ->joinList()
                ->when($request->today, function ($query) use ($request) {
                    $query->where('r1.hari', $request->today);
                })
                ->select(
                    'detail_schedule.*',
                    'r2.nama as nama_poly',
                    'r2.ruangan as nama_ruangan',
                    'r2.jam_praktek as jam_praktek'
                )
                ->get();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
