<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Profile;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HistoryVisitController extends Controller
{
    use ApiResponse;

    public function getList(Request $request) {
        try {
            $profile = new Profile();
            $profile = $profile->query()
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$profile) {
                return $this->error('profile not found', 404);
            }

            $listData = new History();
            $listData = $listData->query()
                ->where('r1.profile_id', $profile->id)
                ->joinList()
                ->select('histories.*', 'r1.profile_id', 'r1.no_rm', 'r1.no_registrasi')
                ->get();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
