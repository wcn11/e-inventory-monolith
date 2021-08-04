<?php

namespace App\Exceptions;

use Exception;

class SkuNotExist extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    public function render()
    {
        return errorResponse(["sku_not_exist" => $this->getMessage()]);
    }
}
