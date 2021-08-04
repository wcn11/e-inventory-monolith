<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $guarded = [];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stock_request_item(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockRequestItem::class);
    }

    public function sack(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Sack::class, 'product_id');
    }

    public function stock_opname_items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(StockOpnameItems::class);

    }

    public function stock(){

        return $this->hasMany(Stock::class);

    }

    public function limit(){

        return $this->hasMany(Limit::class);

    }
}
