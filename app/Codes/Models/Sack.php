<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Sack extends Model
{
    protected $table = 'sack';

    public $guarded = [];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id');
    }

}
