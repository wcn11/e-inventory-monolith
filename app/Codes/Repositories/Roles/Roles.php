<?php

namespace App\Codes\Repositories\Roles;

use App\Exceptions\RolesDoesNotExist;
use Illuminate\Container\Container;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;
use App\Codes\Repositories\User\Repository as UserRepository;

class Roles extends BaseRepository implements Repository
{

    protected $userRepository;

    public function __construct(Container $app, UserRepository $userRepository)
    {

        parent::__construct($app);

        $this->userRepository = $userRepository;

    }

    public function model(): string
    {

        return Role::class;

    }

    public function createRole($request)
    {

        $role = $this->create([

            'name' => $request['name'],

            'descriptions' => $request['descriptions'],

            'guard_name' => 'web'

        ]);

        return $role->givePermissionTo($request['permissions']);

    }

    public function search($request)
    {

        try {

            $role = Role::findByName('wahyu');

        }catch (RoleDoesNotExist $exception){

            return $exception->getMessage();

        }

        return $role;

    }

    public function givePermission($request){

        $role = $this->isExist($this->getRoleNamesOrId());

        return $role->givePermissionTo('admin');
    }

    public function syncPermission(){

        $rolesId = 3;

        $role = $this->isExist($rolesId);

        return $role->syncPermission();
    }

    public function revokePermissionTo(){

        $rolesId = $this->getRoleNamesOrId('id');

        $role = $this->isExist($rolesId);

        return $role->revokePermissionTo();
    }

    public function getRoleNamesOrId($type = 'id'){

        $user = auth()->user();

        if ($type === 'id'){

            return $user->roles[0]->id;

        }

        return $user->getRoleNames();

    }

    public function isExist($rolesId){

        $role = $this->roles->find($rolesId);

        if (!$role){

            throw new RolesDoesNotExist($rolesId);

        }

        return $role;
    }

    public function getRoleByName(){

        $user = $this->userRepository->getAll();

        return $user;
    }

}
