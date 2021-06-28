<?php

namespace App\Codes\Repositories\Permission;

interface Repository{
    public function getAll();

    public function createPermission($request);

    public function searchPermissions($request);
}
