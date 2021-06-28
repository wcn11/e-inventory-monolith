<?php

namespace App\Codes\Repositories\User;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class User extends BaseRepository implements Repository
{

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    public function model(): string
    {
        // TODO: Implement model() method.
        return \App\Codes\Models\User::class;
    }

    public function getAllWithRoles()
    {
        // TODO: Implement getAll() method.
        return $this->with('roles')->get();
    }
}
