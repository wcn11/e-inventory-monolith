<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use App\Codes\Providers\Permission\Provider as PermissionProvider;
use App\Codes\Providers\Roles\Provider as RolesProvider;
use App\Codes\Providers\Stock\Provider as StockProvider;
use App\Codes\Providers\User\Provider as UserProvider;

use App\Codes\Mappers\Mapper;
use App\Codes\Validators\Validator;
use App\Codes\Mappers\Repository as MapperRepository;
use App\Codes\Validators\Repository as ValidatorRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(PermissionProvider::class);

        $this->app->register(StockProvider::class);

        $this->app->register(UserProvider::class);

        $this->app->register(RolesProvider::class);

        //for validation

        $this->app->bind(MapperRepository::class, Mapper::class);

        $this->app->bind(ValidatorRepository::class, Validator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(125);
    }
}
