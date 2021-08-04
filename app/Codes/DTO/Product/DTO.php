<?php


namespace App\Codes\DTO\Product;


class DTO
{
    const storeDTO = [
        'sku',
        'name',
        'price',
        'weight',
        'position',
        'category_id',
        'description',
        'is_enable' => '',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
    ];

    const storeRules = [
        'sku' => 'required',
        'name' => 'required',
        'price' => 'required',
        'weight' => 'required',
        'position' => 'required',
        'category_id' => 'required',
        'description' => 'required',
        'is_enable' => '',
        'slug' => 'required',
        'meta_title' => 'required',
        'meta_description' => 'required',
        'meta_keywords' => 'required',
        'image' => 'required|max:3000',
    ];

    const updateDTO = [
        'sku',
        'name',
        'position',
        'description',
        'is_enable',
        'price',
        'category_id',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
    ];

    const updateRules = [
        'sku' => 'required',
        'name' => 'required',
        'position' => 'required',
        'description' => 'required',
        'is_enable' => '',
        'price' => 'required',
        'category_id' => 'required',
        'slug' => 'required',
        'meta_title' => 'required',
        'meta_description' => 'required',
        'meta_keywords' => 'required',
        'image' => 'max:3000',
    ];

}
