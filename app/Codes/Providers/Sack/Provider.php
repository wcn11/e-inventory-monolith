<?php

namespace App\Codes\Providers\Sack;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\Sack\Repository;
use App\Codes\Repositories\Sack\Sack as SackRepository;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, SackRepository::class);
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


