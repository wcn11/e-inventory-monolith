<?php

namespace App\Codes\Providers\User;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\User\Repository;
use App\Codes\Repositories\User\User as UserRepository;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}


