<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockRequest extends Model
{
    use SoftDeletes;
    protected $table = 'stock_request';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    public function stock_request_item(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockRequestItem::class);
    }
}
