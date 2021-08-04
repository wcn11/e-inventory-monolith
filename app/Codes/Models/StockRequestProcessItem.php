<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequestProcessItem extends Model
{
    protected $table = 'stock_request_process_item';

    protected $guarded = [];

    public function stock_request_process(): \Illuminate\Database\Eloquent\Relations\BelongsTo  {
        return $this->belongsTo(StockRequestProcess::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
