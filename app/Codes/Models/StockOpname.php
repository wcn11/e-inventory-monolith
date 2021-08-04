<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOpname extends Model
{
    use SoftDeletes;

    protected $table = 'stock_opname';

    protected $guarded = [];

    public function stock_opname_items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(StockOpnameItems::class);

    }
}
