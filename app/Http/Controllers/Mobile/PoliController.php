<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Poly;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    use ApiResponse;

    public function getList(Request $request) {

        try {
            $listData = Poly::all();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
