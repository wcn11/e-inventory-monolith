<?php

namespace App\Codes\Repositories\Stock;


use App\Codes\Models\StockRequest;
use Prettus\Repository\Eloquent\BaseRepository;

class Stock extends BaseRepository implements Repository
{

    public function model(): string
    {
        // TODO: Implement model() method.
        return StockRequest::class;
    }
}
