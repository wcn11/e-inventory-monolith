<?php


namespace App\Codes\DTO\Limit;


class DTO
{
    const setLimitDTO = [
        'user_id',
        'limit_min',
        'limit_max'
    ];

    const setLimitRules = [
        'user_id' => 'required',
        'limit_min'=> 'required',
        'limit_max' => 'required'
    ];
}
