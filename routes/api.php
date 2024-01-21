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
use App\Http\Controllers\Mobile\DoctorController;
use App\Http\Controllers\Mobile\GetUserProfileController;
use App\Http\Controllers\Mobile\HistoryVisitController;
use App\Http\Controllers\Mobile\MedicalCardController as MobileMedicalCardController;
use App\Http\Controllers\Mobile\MemberRegistrationController;
use App\Http\Controllers\Mobile\OcrController;
use App\Http\Controllers\Mobile\PoliController;
use App\Http\Controllers\Mobile\ScheduleController as MobileScheduleController;

use Illuminate\Support\Facades\Route;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

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

Route::prefix('v1/visithistory')->controller(VisitHistoryController::class)->group(function() {
  Route::get    ('/'     , 'getAllData'  );
  Route::get    ('/{id}' , 'getDataById' );
  Route::post   ('/'     , 'upsertData'  );
  Route::delete ('/{id}' , 'deleteData'  );
});

Route::prefix('mobile')->group(function() {

  Route::get ('doctor'              , [DoctorController             ::class, 'getList'     ])                         ;
  Route::get ('poly'                , [PoliController               ::class, 'getList'     ])                         ;
  Route::get ('schedule'            , [MobileScheduleController     ::class, 'getList'     ])                         ;
  Route::get ('history'             , [HistoryVisitController       ::class, 'getList'     ]) ->middleware('auth:api');
  Route::get ('medical-card'        , [MobileMedicalCardController  ::class, 'getFirst'    ])->middleware('auth:api') ;
  Route::get ('profile-user'        , [GetUserProfileController     ::class, 'getFirst'    ])->middleware('auth:api') ;
  Route::post('getImageText'        , [OcrController                ::class, 'getImageText']);
  Route::post('member-registration' , [MemberRegistrationController ::class, 'saveFile'    ])                         ;

  Route::get('logout'  , function() {
    $tokenRepository = app(TokenRepository::class);
    $getTokenId = $tokenRepository->forUser(auth()->user()->id);

    $refreshTokenRepository = app(RefreshTokenRepository::class);

    foreach ($getTokenId as $key => $value) {
      // Revoke an access token...
      $tokenRepository->revokeAccessToken($value['id']);
      
      // Revoke all of the token's refresh tokens...
      $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($value['id']);
    }

    return response()->json(['message' => 'Successfully logged out']);
  })->middleware('auth:api');
});

