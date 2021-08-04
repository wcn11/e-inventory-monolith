<?php

namespace App\Exceptions;

use Exception;

class ValidatorException extends Exception
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

    public function render(): \Illuminate\Http\RedirectResponse
    {
        return back()->withErrors(
            json_decode($this->getMessage(), true)
        );
    }
}
