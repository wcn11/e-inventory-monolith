<?php

namespace App\Codes\Providers\Product;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\Product\Repository;
use App\Codes\Repositories\Product\Product as ProductRepository;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, ProductRepository::class);
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


