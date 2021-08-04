<?php

namespace App\Codes\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{

    protected $model;

    public function __construct(

        Model $model

    )
    {

        $this->model = $model;

    }

    public function getInstance(): Model
    {

        return $this->model;

    }

}
