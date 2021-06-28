<?php

namespace App\Http\Controllers;

use App\Codes\Models\User;
use Illuminate\Http\Request;
use App\Codes\Repositories\User\Repository as UserRepository;
use App\Codes\Repositories\Roles\Repository as RoleRepository;
use App\Codes\Forms\User\Form as Form;

class UserController extends Controller
{

    protected $request;

    protected $model;

    protected $form;

    protected $userRepository;

    protected $roleRepository;

    public function __construct(Request $request, Form $form, RoleRepository $roleRepository, User $model, UserRepository $userRepository)
    {
        $this->request = $request->all();
        $this->model = $model;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->form = $form;
    }

    public function index(){

        $users =  $this->userRepository->getAllWithRoles();

        return view('pages.pengguna.index', compact('users'));
    }

    public function create(){

        $roles = $this->roleRepository->all();

        return view('pages.pengguna.create', compact('roles'));
    }
    public function edit($id){

        $user = $this->userRepository->findOrFail($id);

        $roles = $this->roleRepository->all();

        return view('pages.pengguna.update', compact('user', 'roles'));
    }

    public function store()
    {

        return $this->form->store($this->request);
    }

    public function update($id){

        return $this->form->update($id, $this->request);
    }
}
