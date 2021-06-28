<?php

namespace App\Codes\Forms\Stock;

use App\Codes\Mappers\Mapper;
use App\Codes\DTO\Stock\Stock as stockDTO;
use App\Codes\Repositories\Stock\Repository as StockRepository;
use App\Codes\Validators\Validator;

class Form {

    protected $stock;

    protected $mapper;

    protected $validator;

    public function __construct(
        StockRepository $stock,
        Mapper $mapper,
        Validator $validator
    ){
        $this->stock = $stock;

        $this->mapper = $mapper;

        $this->validator = $validator;
    }

    public function coba($input){

        $stockDTO = $this->mapper->filter($input, stockDTO::stockInDTO);

        $this->validator->valid($stockDTO, stockDTO::stockInRules);

        return $input;
    }
}
