<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{

    protected $table = 'limit_stock';

    protected $guarded = [];

    public function product(){

        return $this->belongsTo(Product::class);

    }
}
