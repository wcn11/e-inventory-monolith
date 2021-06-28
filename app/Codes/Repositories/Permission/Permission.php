<?php

namespace App\Codes\Repositories\Permission;

use Illuminate\Container\Container;
use Prettus\Repository\Eloquent\BaseRepository;

class Permission extends BaseRepository implements Repository
{

    protected $permission;

    public function __construct(Container $app)
    {
        parent::__construct($app);
        $this->permission = $this->model();
    }

    public function model(): string
    {
        // TODO: Implement model() method.
        return \Spatie\Permission\Models\Permission::class;
    }

    public function getAll()
    {
        // TODO: Implement all() method.
        return $this->all();
    }

    public function createPermission($request)
    {
        // TODO: Implement create() method.
        return $this->create($request);
    }

    public function searchPermissions($request)
    {
        // TODO: Implement create() method.
        $name = "viewer";
        $permission = $this->findWhere(["name" => $name])->first();

        if (!$permission){
            return "Jenis Izin <b>$name</b> Tidak Ditemukan!";
        }

        return $permission;

    }
}
