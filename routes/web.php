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
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/'                 , [DashboardController     ::class, 'index'   ])->name('dashboard'    );
Route::get('/user'             , [UserController          ::class, 'getView' ])->name('user'         );
Route::get('/attachment'       , [AttachmentController    ::class, 'getView' ])->name('attachment'   );
Route::get('/poly'             , [PolyController          ::class, 'getView' ])->name('poly'         );
Route::get('/profile'          , [ProfileController       ::class, 'getView' ])->name('profile'      );
Route::get('/profile/add'      , [ProfileController       ::class, 'addView' ])->name('profile-add'  );
Route::get('/profile/add/{id}' , [ProfileController       ::class, 'addView' ])->name('profile-edit' );
Route::get('/dokter'           , [DoctorProfileController ::class, 'getView' ])->name('dokter'       );
Route::get('/dokter/add'       , [DoctorProfileController ::class, 'addView' ])->name('dokter-add'   );
Route::get('/dokter/add/{id}'       , [DoctorProfileController ::class, 'addView' ])->name('dokter-edit'   );
Route::get('/schedule'         , [ScheduleController      ::class, 'getView' ])->name('schedule'     );
Route::get('/medicalcard'      , [MedicalCardController   ::class, 'getView' ])->name('medicalcard'  );
Route::get('/registation'      , [RegistationController   ::class, 'getView' ])->name('registation'  );
Route::get('/visithistory'     , [VisitHistoryController  ::class, 'getView' ])->name('visithistory' );