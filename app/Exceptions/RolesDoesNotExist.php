<?php

namespace App\Exceptions;

use Throwable;

class RolesDoesNotExist extends \Exception
{

    protected $rolesId;

    public function __construct($rolesId, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->rolesId = $rolesId;
    }

    public function render(): \Illuminate\Http\RedirectResponse
    {
        return back()->withErrors([
            "roles" => "Tidak Ada Peran Berdasarkan ID: $this->rolesId."
        ]);
    }
}
