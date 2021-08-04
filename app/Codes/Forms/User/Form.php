<?php

namespace App\Codes\Forms\User;

use App\Codes\Mappers\Mapper;
use App\Codes\DTO\User\DTO as userDTO;
use App\Codes\Repositories\User\Repository as UserRepository;
use App\Codes\Validators\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Form {

    protected $userRepository;

    protected $mapper;

    protected $validator;

    public function __construct(
        UserRepository $userRepository,
        Mapper $mapper,
        Validator $validator
    ){
        $this->userRepository = $userRepository;

        $this->mapper = $mapper;

        $this->validator = $validator;
    }

    public function store($request)
    {

        $stockDTO = $this->mapper->filter($request, userDTO::userStoreDTO);

        $this->validator->valid($stockDTO, userDTO::userStoreRules);

        $user = $this->userRepository->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'is_enable' => $request['is_enable'] ?? "off",
            'password' => Hash::make($request['password']),
            'api_token' => Str::random(80),
        ]);

        $user->province()->attach($request['region']);

        $user->assignRole($request['role']);

        session()->flash("user_created", "Pengguna <b>" . $request['name']  . "</b> berhasil dibuat!");

        return  redirect()->route('user');
    }

    public function update($id, $request){

        $stockDTO = $this->mapper->filter($request, userDTO::userUpdateDTO);

        $this->validator->valid($stockDTO, userDTO::userUpdateRules);

        $request = array_filter($request);

        $request['is_enable'] = $request['is_enable'] ?? "off";

        $request['password'] = Hash::make($request['password']);

        $user = $this->userRepository->findOrFail($id);

        $user->update($request);

        $user->province()->detach();

        $user->province()->attach($request['region']);

        $user->syncRoles($request['role']);

        return  redirect()->route('user')->with("user_updated", "Pengguna <b>" . $request['name']  . "</b> berhasil di update!");

    }

    public function destroy($id){

        $user = $this->userRepository->delete($id);

        return successResponse([

            "route" => route('user')

        ]);

    }

}
