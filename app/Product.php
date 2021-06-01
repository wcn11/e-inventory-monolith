<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function stock_reques_itemt(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(StockRequestItem::class, 'product_stock_request_item');
    }
}
