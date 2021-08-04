<?php

namespace App\Codes\Providers\Limit;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\Limit\Repository;
use App\Codes\Repositories\Limit\Limit;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, Limit::class);
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


