<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequestItem extends Model
{
    protected $table = 'stock_request_item';

    protected $guarded = [];

    public function stock_request(): \Illuminate\Database\Eloquent\Relations\BelongsTo  {
        return $this->belongsTo(StockRequest::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
