<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\profile;
use App\Models\visit_history;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HistoryVisitController extends Controller
{
    use ApiResponse;

    public function getList(Request $request) {
        try {
            $profile = new profile();
            $profile = $profile->query()
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$profile) {
                return $this->error('profile not found', 404);
            }

            $listData = new visit_history();
            $listData = $listData->query()
                ->where('visithistory.profile_id', $profile->id)
                ->joinList()
                ->get();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
