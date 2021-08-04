<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockRequestConfirmation extends Model
{
    use SoftDeletes;

    protected $table = 'stock_request_confirmation';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    public function stock_request_confirmation_items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(StockRequestConfirmationItem::class);

    }
}
