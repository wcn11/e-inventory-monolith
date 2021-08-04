<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Codes\Forms\Roles\Form as RolesForm;

class RolesController extends Controller
{
    protected $request;

    protected $rolesRepository;

    protected $rolesForm;

    public function __construct(Request $request, RolesForm $rolesForm)
    {
        $this->request = $request->all();

        $this->rolesForm = $rolesForm;
    }

    public function create(){

        return $this->rolesForm->create($this->request);

    }

    public function update($id){

        return $this->rolesForm->update($id, $this->request);

    }
}
