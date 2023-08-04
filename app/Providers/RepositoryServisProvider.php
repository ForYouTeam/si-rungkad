<?php

namespace App\Providers;

use App\Interfaces\AttachmentInterfaces;
use App\Interfaces\PolyInterfaces;
use App\Repositories\AttachmentRepository;
use App\Repositories\PolyRepository;
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
