<?php

namespace App\Codes\Validators;

use App\Exceptions\ValidatorException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Factory;

class Validator implements Repository
{

    protected $errors;

    protected $rules;

    protected $messages;

    protected $id;

    protected $data;

    protected $value;

    protected $validator;

    public function __construct(

        Factory $validator

    )
    {

        $this->validator = $validator;

        $this->validator->setPresenceVerifier(app('validation.presence'));

    }

    private function passes(): Validator
    {

        if (!is_array($this->value)) {

            $this->rules = [];

            return $this;

        }

        $this->rules = $this->value;

        if (!empty($this->id)) {

            array_walk($this->rules, function (&$value) {

                $value = str_replace('{id}', $this->id, $value);

            });

        }

        return $this;

    }

    private function with($dto, $rules, $id): Validator

    {

        $this->value = $rules;

        $this->data = $dto;

        $this->id = $id;

        if(isset($id)){

            $this->id = $id;

            $this->data['id'] = $id;

        }

        return $this;

    }

    /**
     * @throws BindingResolutionException
     */
    private function validation()
    {

        $validator = app('validator')->make($this->data, $this->rules);

        if ($validator->fails()) {

            $larr_errors = $validator->errors()->getMessages();

            $arr_errors = [];

            foreach ($larr_errors as $key => $value) {

                foreach ($value as $k => $v){

                    $arr_errors[$key] = $v;

                }
            }

            return [
                    "status" => false,
                    "message" => $arr_errors
                ];

        }

        return [
            "status" => true
        ];

    }

    public function errors()
    {

        return $this->errors;

    }

    /**
     * @throws BindingResolutionException
     */
    public function valid($dto, $rules, $id = null)
    {

        return $this->with($dto, $rules, $id)

            ->passes()

            ->validation();

    }

}
