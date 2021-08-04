<?php

namespace App\Codes\Providers\Stock;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\Stock\Stock;
use App\Codes\Repositories\Stock\Repository;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, Stock::class);
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


