<?php

use App\Http\Controllers\BackOffice\AttachmentController;
use App\Http\Controllers\BackOffice\PolyController;
use App\Interfaces\PolyInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1/poly')->controller(PolyController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/attachment')->controller(AttachmentController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});
