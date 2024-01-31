<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Profile;
use App\Models\User;
use App\Models\Visit;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitRegistrationController extends Controller
{
    use ApiResponse;
    public function register(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::whereId($userId)->first();
        $now = Carbon::now();

        if (!$user) {
            return $this->error('user tidak ditemukan', 422);
        }

        try {
            $visitModel = new Visit;
            $profile = $this->getProfile($userId);

            if (!$profile) {
                return $this->error('pengguna tidak ditemukan', 422);
            }

            DB::beginTransaction();

            $visit = $visitModel->create([
                "profile_id" => $profile->id,
                "no_rm" => $profile->no_rm,
                "no_registrasi" => $this->generateRandomRegistrationNumber(),
                "poly_id" => $request->poly_id,
                "created_at" => $now,
                "updated_at" => $now,
            ]);

            History::create([
                "visit_id" => $visit->id,
                "ket" => "silahkan berkunjung sesuai jadwal",
                "tgl" => $now->format('Y-m-d'),
                "visit_sugest" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ]);

            DB::commit();
            return $this->success($visit);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }

    public function avaible()
    {
        try {
            $now = Carbon::now()->toDateString();
            $userId = auth()->user()->id ?? 0;
            $profile = $this->getProfile($userId);

            if (!$profile) {
                return $this->error('Pengguna tidak ditemukan', 422);
            }

            $visit = Visit::where('profile_id', $profile->id)
                ->select(
                    'visit.*',
                    'poly.nama as nama_poly',
                    'poly.ruangan as nama_ruangan',
                    'poly.jam_praktek as waktu_kunjungan',
                )
                ->Leftjoin('poly', 'visit.poly_id', '=', 'poly.id')
                ->whereDate('visit.created_at', $now)
                ->first();
            $result = [
                "status" => $visit ? "process" : "empty",
                "data" => $visit
            ];

            return $this->success($result);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    private function getProfile(int $userId)
    {
        $profile = Profile::where('user_id', $userId)->first();
        return $profile;
    }

    private function generateRandomRegistrationNumber()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $registrationNumber = '';

        // Loop to generate a random alphanumeric registration number
        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $registrationNumber .= $characters[$index];
        }

        return (`MOB` . $registrationNumber);
    }
}
