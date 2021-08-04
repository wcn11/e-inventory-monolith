<?php

namespace App\Codes\Providers\StockOpname;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\StockOpname\Repository;
use App\Codes\Repositories\StockOpname\StockOpname;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, StockOpname::class);
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


