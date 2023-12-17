<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\poly;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    use ApiResponse;

    public function getList(Request $request) {

        try {
            $listData = poly::all();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }

        return $this->success($listData);
    }
}
