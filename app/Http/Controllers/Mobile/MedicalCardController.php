<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicalCardController extends Controller
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

            $profile = [
                'id'             => $profile->id,
                'tanggal_daftar' => Carbon::parse($profile->created_at)->format('d-M-Y'),
                'nama_profile'   => $profile->nama,
                'no_rm'          => $profile->no_rm
            ];
                
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($profile);
    }
}
