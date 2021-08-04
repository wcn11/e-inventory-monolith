<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockRequestProcess extends Model
{
    use SoftDeletes;

    protected $table = 'stock_request_process';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    public function stock_request_process_items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(StockRequestProcessItem::class);

    }
}
