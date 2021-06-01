<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Roles extends Model
{
    protected $table = 'roles';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
