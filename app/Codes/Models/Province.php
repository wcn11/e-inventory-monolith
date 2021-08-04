<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{

    protected $table = 'provinces';

    protected $guarded = [];


    public function user(){

        return $this->belongsToMany(User::class);

    }

}
