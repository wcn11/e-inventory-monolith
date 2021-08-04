<?php

namespace App\Codes\Forms\Roles;

use App\Codes\Mappers\Mapper;
use App\Codes\Repositories\Roles\Repository as RoleRepository;
use App\Codes\Validators\Validator;
use App\Codes\DTO\Roles\DTO as RoleDTO;
use Illuminate\Support\Facades\DB;
use App\Codes\Repositories\Permission\Permission as PermissionRepository;

class Form {

    protected $role;

    protected $mapper;

    protected $validator;

    protected $permissionRepository;

    public function __construct(

        RoleRepository $role,

        Mapper $mapper,

        Validator $validator,

        PermissionRepository $permissionRepository

    ){
        $this->role = $role;

        $this->mapper = $mapper;

        $this->validator = $validator;

        $this->permissionRepository = $permissionRepository;
    }

    public function create($input){

        $roleDTO = $this->mapper->filter($input, RoleDTO::createDTO);

        $validator = $this->validator->valid($roleDTO, RoleDTO::createRules);

        if (!$validator['status']){

            return response()->json($validator, 400);

        }

        $exist = $this->role->findWhere(["name" => $input['name']])->first();

        if ($exist){

            return errorResponse("Peran Sudah Ada!");

        }

        return successResponse($this->role->createRole($input));
    }

    public function update($id, $input){

        $roleDTO = $this->mapper->filter($input, RoleDTO::updateDTO);

        $validator = $this->validator->valid($roleDTO, RoleDTO::updateRules);

        if (!$validator['status']){

            return response()->json($validator, 400);

        }

        $role = $this->role->findOrFail($id);

        $role->update($input);

        $role->syncPermissions([]);

        if (is_array($input['permissions'])){

            foreach ($input['permissions'] as $permission){

                $perm = $this->permissionRepository->findByName($permission, "web");

                DB::table('role_has_permissions')->insert([
                    "permission_id" => $perm->id,
                    "role_id" => $role->id
                ]);

            }

        }else{

            $permissionsJSON = json_decode($input['permissions'], true);

            foreach ($permissionsJSON as $permission){

                $perm = $this->permissionRepository->findWhere([ "id" => $permission['id']]);

                DB::table('role_has_permissions')->insert([
                    "permission_id" => $perm[0]->id,
                    "role_id" => $role->id
                ]);

            }
        }

        return successResponse();

    }

    public function delete($id){

        return $this->role->delete($id);

    }
}
