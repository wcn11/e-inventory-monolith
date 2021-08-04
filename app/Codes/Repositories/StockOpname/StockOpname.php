<?php

namespace App\Codes\Repositories\StockOpname;

use Illuminate\Container\Container;
use Prettus\Repository\Eloquent\BaseRepository;

class StockOpname extends BaseRepository implements Repository
{

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }


    public function model(): string
    {
        // TODO: Implement model() method.
        return \App\Codes\Models\StockOpname::class;
    }
}
