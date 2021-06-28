<?php


namespace App\Codes\DTO\User;


class DTO
{
    const userStoreDTO = [
        'name',
        'email',
        'password'
    ];

    const userStoreRules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'confirmed|min:6',
    ];
    const userUpdateDTO = [
        'name',
        'email',
        'role',
        'password',
    ];

    const userUpdateRules = [
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
        'password' => 'confirmed|min:6',
    ];
}
