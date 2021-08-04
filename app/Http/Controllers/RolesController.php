<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes\Repositories\Roles\Repository as RoleRepository;
use App\Codes\Repositories\User\Repository as UserRepository;
use App\Codes\Forms\Roles\Form;

class RolesController extends Controller
{
    protected $request;

    protected $rolesRepository;

    protected $userRepository;

    protected $form;

    public function __construct(Request $request, RoleRepository $rolesRepository, UserRepository $userRepository, Form $form)
    {
        $this->request = $request;

        $this->rolesRepository = $rolesRepository;

        $this->userRepository = $userRepository;

        $this->form = $form;
    }

    public function index(){

        $roles =  $this->rolesRepository->all();

        return view('pages.peran.index',  compact('roles'));

    }

    public function create(){

        return view('pages.peran.create');

    }

    public function edit($id){

        $role = $this->rolesRepository->findOrFail($id);

        $permissions = $role->permissions;

        return view('pages.peran.edit', compact('role', 'permissions'));

    }

    public function update($id){

        return $this->form->update($id, $this->request->all());

    }

    public function store(){

        return $this->rolesRepository->create($this->request);

        return view('pages.peran.create');

    }

    public function delete($id){

        $this->rolesRepository->delete($id);

        return back();

    }

    public function search(){

        return $this->rolesRepository->search($this->request);

        return view('pages.peran.create');

    }

    public function givePermission(){
        return $this->rolesRepository->getRoleByName();
//        return $this->rolesRepository->givePermission($this->request);

        return view('pages.peran.create');

    }

    public function roles(){

        return $this->rolesRepository->getRoleNames($this->request);

        return view('pages.peran.create');

    }
}
