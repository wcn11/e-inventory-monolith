<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Codes\Forms\User\Form as Form;

class UserController extends Controller
{
    protected $request;

    protected $form;

    public function __construct(Request $request, Form $form)
    {
        $this->request = $request->all();

        $this->form = $form;
    }

    public function destroy($id){

        return $this->form->destroy($id);

    }
}
