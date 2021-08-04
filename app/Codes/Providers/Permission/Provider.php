<?php

namespace App\Codes\Providers\Permission;

use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\Permission\Repository;
use App\Codes\Repositories\Permission\Permission;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, Permission::class);
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


