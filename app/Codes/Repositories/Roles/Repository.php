<?php

namespace App\Codes\Repositories\Roles;

use Prettus\Repository\Contracts\RepositoryInterface;

interface Repository extends RepositoryInterface{

    public function createRole($request);

    public function search($request);

    public function givePermission($request);

    public function getRoleNamesOrId();

    public function getRoleByName();
}
