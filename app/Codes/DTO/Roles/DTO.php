<?php


namespace App\Codes\DTO\Roles;


class DTO
{
    const createDTO = [
        'name',
        'descriptions',
        'permissions'
    ];

    const createRules = [
        'name' => 'required',
        'descriptions' => 'required',
        'permissions' => 'required'
    ];

    const updateDTO = [
        'name',
        'descriptions',
        'permissions'
    ];

    const updateRules = [
        'name' => 'required',
        'descriptions' => 'required',
        'permissions' => 'required'
    ];
}
