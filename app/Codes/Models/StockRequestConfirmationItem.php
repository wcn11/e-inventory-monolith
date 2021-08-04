<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequestConfirmationItem extends Model
{
    protected $table = 'stock_request_confirmation_item';

    protected $guarded = [];

    public function stock_request_confirmation(): \Illuminate\Database\Eloquent\Relations\BelongsTo  {
        return $this->belongsTo(StockRequestConfirmation::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_stock_request_confirmation_item', 'stock_request_confirmation_item_id', 'product_id');
    }
}
