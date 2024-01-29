<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/user'            , [UserController         ::class, 'getView'  ])->middleware(['auth', 'role:super-admin'])->name('user'        );
Route::get('/attachment'      , [AttachmentController   ::class, 'getView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('attachment'  );
Route::get('/poly'            , [PolyController         ::class, 'getView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('poly'        );
Route::get('/profile'         , [ProfileController      ::class, 'getView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('profile'     );
Route::get('/profile/add'     , [ProfileController      ::class, 'addView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('profile-add' );
Route::get('/profile/add/{id}', [ProfileController      ::class, 'addView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('profile-edit');
Route::get('/dokter'          , [DoctorProfileController::class, 'getView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('dokter'      );
Route::get('/dokter/add'      , [DoctorProfileController::class, 'addView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('dokter-add'  );
Route::get('/dokter/add/{id}' , [DoctorProfileController::class, 'addView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('dokter-edit' );
Route::get('/schedule'        , [ScheduleController     ::class, 'getView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('schedule'    );
Route::get('/registrasi'      , [RegistationController  ::class, 'getView'  ])->middleware(['auth', 'role:super-admin|admin'])->name('registrasi'  );
Route::get('/registrasi/{id}' , [VisitHistoryController ::class, 'getDetail'])->middleware(['auth', 'role:admin'])->name('regis-detail');

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/loginprocess' , [AuthController ::class, 'login' ])->name('login-process' );
Route::get('/logout'       , [AuthController ::class, 'logout' ])->middleware(['auth'])->name('logout');
