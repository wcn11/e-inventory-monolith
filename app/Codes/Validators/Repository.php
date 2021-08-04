<?php

namespace App\Codes\Validators;

interface Repository{

    public function errors();

    public function valid($dto, $rules,$id = null);

}
