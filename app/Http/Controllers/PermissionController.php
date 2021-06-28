<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes\Repositories\Permission\Repository as PermissionRepository;

class PermissionController extends Controller
{
    protected $request;

    protected $permissionRepository;

    public function __construct(Request $request, PermissionRepository $permissionRepository)
    {
        $this->request = $request;

        $this->permissionRepository = $permissionRepository;
    }

    public function index(){

        return $this->permissionRepository->getAll();

        return view('pages.peran.index');

    }

    public function create(){

        return $this->permissionRepository->createPermission($this->request);

        return view('pages.peran.create');

    }

    public function search(){

        return $this->permissionRepository->searchPermissions($this->request);

        return view('pages.peran.create');

    }

    public function delete(){

        return $this->permissionRepository->searchPermissions($this->request);

        return view('pages.peran.create');

    }
}
