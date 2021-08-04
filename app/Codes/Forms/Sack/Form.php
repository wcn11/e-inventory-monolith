<?php

namespace App\Codes\Forms\Sack;

use App\Codes\Mappers\Mapper;
use App\Codes\DTO\User\DTO as userDTO;
use App\Codes\Repositories\Sack\Repository as SackRepository;
use App\Codes\Validators\Validator;

class Form {

    protected $sackRepository;

    protected $mapper;

    protected $validator;

    public function __construct(
        SackRepository $sackRepository,
        Mapper $mapper,
        Validator $validator
    ){
        $this->sackRepository = $sackRepository;

        $this->mapper = $mapper;

        $this->validator = $validator;
    }

    public function store($request)
    {

        $stockDTO = $this->mapper->filter($request, userDTO::userStoreDTO);

        $this->validator->valid($stockDTO, userDTO::userStoreRules);
    }

}
