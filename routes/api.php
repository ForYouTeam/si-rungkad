<?php

use App\Http\Controllers\BackOffice\AttachmentController;
use App\Http\Controllers\BackOffice\DoctorProfileController;
use App\Http\Controllers\BackOffice\MedicalCardController;
use App\Http\Controllers\BackOffice\PolyController;
use App\Http\Controllers\BackOffice\ProfileController;
use App\Http\Controllers\BackOffice\RegistationController;
use App\Http\Controllers\BackOffice\ScheduleController;
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\BackOffice\VisitHistoryController;
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

Route::prefix('v1/user')->controller(UserController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/profile')->controller(ProfileController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/doctorprofile')->controller(DoctorProfileController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/schedule')->controller(ScheduleController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/medicalcard')->controller(MedicalCardController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/registation')->controller(RegistationController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('v1/visithistory')->controller(VisitHistoryController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

