<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class StockRequestItem extends Model
{
    protected $table = 'stock_request_item';

    protected $guarded = [];

    public function stock_request(): \Illuminate\Database\Eloquent\Relations\BelongsTo  {
        return $this->belongsTo(StockRequest::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_stock_request_item', 'stock_request_item_id', 'product_id');
    }
}
