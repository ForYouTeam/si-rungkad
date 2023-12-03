<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\medical_card;
use App\Models\profile;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MedicalCardController extends Controller
{
    use ApiResponse;

    public function getFirst(Request $request) {

        try {
            $profile = new profile();
            $profile = $profile->query()
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$profile) {
                return $this->error('profile not found', 404);
            }

            $listData = new medical_card();
            $listData = $listData->query()
                ->where('profile_id', $profile->id)
                ->first();
                
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
