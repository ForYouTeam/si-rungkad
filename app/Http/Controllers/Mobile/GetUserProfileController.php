<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class GetUserProfileController extends Controller
{
    use ApiResponse;
    
    public function getFirst(Request $request) {

        try {
            $profile = new Profile();
            $profile = $profile->query()
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$profile) {
                return $this->error('profile not found', 404);
            }
                
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($profile);
    }
}
