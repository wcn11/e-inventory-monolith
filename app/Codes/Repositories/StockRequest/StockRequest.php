<?php

namespace App\Codes\Repositories\StockRequest;

use App\Codes\Models\StockRequest as Model;
use Prettus\Repository\Eloquent\BaseRepository;

class StockRequest extends BaseRepository implements Repository
{

    public function model(): string
    {
        // TODO: Implement model() method.
        return Model::class;
    }
}
