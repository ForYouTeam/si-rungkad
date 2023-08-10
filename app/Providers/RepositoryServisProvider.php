<?php

namespace App\Providers;

use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\PolyInterfaces;
use App\Interfaces\ProfileInterfaces;
use App\Interfaces\UserInterfaces;
use App\Repositories\AttachmentRepository;
use App\Repositories\PolyRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
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
