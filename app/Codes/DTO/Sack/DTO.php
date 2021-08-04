<?php


namespace App\Codes\DTO\Sack;


class DTO
{
    const storeDTO = [
        'contents',
        'weight_min',
        'weight_max'
    ];

    const storeRules = [
        'contents' => 'required',
        'weight_min' => 'required',
        'weight_max' => 'required',
    ];

}
