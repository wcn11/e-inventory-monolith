<?php

namespace App\Codes\Mappers;

class Mapper implements Repository
{

    public function filter($input, $dto)
    {

        $data = [];

        $fields = $dto;

        if (!is_null($fields)) {

            foreach ($fields as $value) {

                if (array_key_exists($value, $input)) {

                    $data[$value] = $input[$value] ?: $input[$value];

                } else {

                    $data[$value] = '';

                }

            }

            return $data;

        }

    }
}
