<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $table = 'stock';

    protected $guarded = [];

    public function product(){

        return $this->belongsTo(Product::class);

    }

    public function user(){

        return $this->belongsTo(User::class);

    }
}
