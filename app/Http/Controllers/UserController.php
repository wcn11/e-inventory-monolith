<?php

namespace App\Http\Controllers;

use App\User;
use App\Services\ImageInterventionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    protected $request;

    protected $model;

    public function __construct(Request $request, ImageInterventionService $imageInterventionService, User $model)
    {
        $this->request = $request;
        $this->model = $model;
    }

    public function index(){
        $users = User::with('roles')->get();

        return view('pages.pengguna.index', compact('users'));
    }
    public function create(){
        $roles = Role::all();
        return view('pages.pengguna.create', compact('roles'));
    }
    public function edit($id){
        $user = $this->model->find($id);
        return view('pages.pengguna.update', compact('user'));
    }

    public function store(){

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }

        if (! isset($this->request['is_enable'])){
            $this->request['is_enable'] = 'off';
        }

        $user = User::create([
            'name' => $this->request['name'],
            'email' => $this->request['email'],
            'is_enable' => $this->request['is_enable'],
            'password' => Hash::make($this->request['password']),
            'api_token' => Str::random(80),
        ]);

        $user->assignRole($this->request['role']);

        return redirect()->route('pengguna');
    }
    public function update(){
        return view('pages.pengguna.update');
    }
}
