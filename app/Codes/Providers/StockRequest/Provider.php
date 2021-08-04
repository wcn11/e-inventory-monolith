<?php

namespace App\Codes\Providers\StockRequest;

use App\Codes\Repositories\StockRequest\StockRequest;
use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\StockRequest\Repository;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, StockRequest::class);
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


