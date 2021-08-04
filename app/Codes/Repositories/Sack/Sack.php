<?php

namespace App\Codes\Repositories\Sack;

use Illuminate\Container\Container;
use Prettus\Repository\Eloquent\BaseRepository;

class Sack extends BaseRepository implements Repository
{

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    public function model(): string
    {
        // TODO: Implement model() method.
        return \App\Codes\Models\Sack::class;
    }
}
