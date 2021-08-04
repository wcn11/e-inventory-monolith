<?php

namespace App\Codes\Forms\Limit;

use App\Codes\Mappers\Mapper;
use App\Codes\Models\Product;
use App\Codes\Validators\Validator;
use App\Codes\DTO\Limit\DTO as LimitDTO;
use App\Codes\Repositories\Limit\Repository as LimitRepository;
use App\Events\LimitChangeEvent;

class Form {
    protected $mapper;

    protected $validator;

    protected $limitRepository;

    public function __construct(

        Mapper $mapper,

        Validator $validator,

        LimitRepository $limitRepository

    ){

        $this->mapper = $mapper;

        $this->validator = $validator;

        $this->limitRepository = $limitRepository;
    }

    public function setLimit($input){

        $roleDTO = $this->mapper->filter($input, LimitDTO::setLimitDTO);

        $validator = $this->validator->valid($roleDTO, LimitDTO::setLimitRules);

        if (!$validator['status']){

            return errorResponse($validator, 400);

        }

        $limit = $this->limitRepository->where(["user_id" => $input['user_id']])->where(["product_id" => $input["product_id"]]);

        $product = Product::find($input['product_id']);

        if ($limit->count() > 0){

            event(new LimitChangeEvent($input['user_id'], "Ambang Batas Produk " . $product['name'] . " Telah Diupdate!" ));

            return successResponse($limit->first()->update([
                "stock_min" => $limit->first()->limit_min + $input['limit_min'],
                "stock_max" => $limit->first()->limit_max + $input['limit_max'],
            ]));

        }

        $data = $this->limitRepository->create([
            "user_id" => $input['user_id'],
            "product_id" => $input['product_id'],
            "stock_min" => $input['limit_min'],
            "stock_max" => $input['limit_max'],
        ]);

        event(new LimitChangeEvent($input['user_id'], "Ambang Batas Produk  " . $product['name'] . " Telah Dibuat!" ));

        return successResponse($data);

    }

    public function delete($id){

        $limit = $this->limitRepository->findWhere(['product_id' => $id])->first();

        if ($limit){

            return successResponse($limit->delete());

        }

        return errorResponse("Data Tidak Ditemukan");

    }

    public function isExists($id){

        return $this->limitRepository->find($id);

    }
}
