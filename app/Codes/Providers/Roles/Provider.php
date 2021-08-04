<?php

namespace App\Codes\Providers\Roles;

use App\Codes\Forms\Roles\Form as FormRoles;
use Illuminate\Support\ServiceProvider;
use App\Codes\Repositories\Roles\Repository;
use App\Codes\Repositories\Roles\Roles;
use Spatie\Permission\Models\Role;

class Provider extends ServiceProvider {


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(Repository::class, Roles::class);

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


