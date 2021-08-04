<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpnameItems extends Model
{

    protected $table = 'stock_opname_items';

    public $timestamps = false;

    protected $guarded = [];

    public function stock_opname()
    {

        return $this->belongsToMany(StockOpname::class);

    }

    public function product(){

        return $this->belongsToMany(Product::class);

    }
}
