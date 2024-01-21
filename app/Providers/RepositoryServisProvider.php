<?php

namespace App\Providers;

use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\DoctorProfileInterfaces;
use App\Interfaces\MedicalCardInterfaces;
use App\Interfaces\PolyInterfaces;
use App\Interfaces\ProfileInterfaces;
use App\Interfaces\ScheduleInterfaces;
use App\Interfaces\UserInterfaces;
use App\Interfaces\VisitHistoryInterfaces;
use App\Repositories\AttachmentRepository;
use App\Repositories\DoctorProfileRepository;
use App\Repositories\PolyRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitHistoryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServisProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PolyInterfaces::class, PolyRepository::class);
        $this->app->bind(AttachmentInterfaces::class, AttachmentRepository::class);
        $this->app->bind(UserInterfaces::class, UserRepository::class);
        $this->app->bind(ProfileInterfaces::class, ProfileRepository::class);
        $this->app->bind(DoctorProfileInterfaces::class, DoctorProfileRepository::class);
        $this->app->bind(ScheduleInterfaces::class, ScheduleRepository::class);
        $this->app->bind(VisitHistoryInterfaces::class, VisitHistoryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
