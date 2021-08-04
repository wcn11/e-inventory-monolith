<?php


namespace App\Codes\DTO\StockOpname;


class StockOpname
{
    const opnameUploadDTO = [
        'file',
        'pj',
    ];

    const opnameUploadRules = [
        'file' => 'required',
        'pj' => 'required',
    ];

    const requestStockDTO = [
        'user_id',
        'stock',
        'total_order',
        'total_sacks',
        'total_weight',
        'sj',
        'pj'
    ];

    const requestStockRules = [
        'user_id' => 'required',
        'stock' => 'required',
        'total_order' => 'required',
        'total_sacks' => 'required',
        'total_weight' => 'required',
        'sj' => 'required',
        'pj' => 'required'
    ];

    const requestConfirmDTO = [
        'request',
    ];

    const requestConfirmRules = [
        'request' => 'required',
    ];

    const processDTO = [
        'request',
    ];

    const processRules = [
        'request',
    ];

}
