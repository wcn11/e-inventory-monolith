<?php

namespace App\Http\Controllers\API;

use App\Codes\Forms\StockOpname\Form;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $request;

    protected $input;

    protected $form;

    public function __construct(Request $request, Form $form)
    {
        $this->request = $request;

        $this->input = $request->all();

        $this->form = $form;
    }

    public function getProducts(){

        return $this->form->getProduct();

    }

    public function process($sjId){

        return $this->form->process($sjId, $this->input);

    }

    public function opnameStore(){

        return $this->form->opnameStore($this->request);

    }

    public function storeConfirmed(){

        return $this->form->confirm($this->request);

    }

    public function getRequestOrder(){

        return $this->form->getRequestOrder($this->input);

    }

    public function requestStore($sjId){

        return $this->form->requestStore($sjId, $this->input);

    }

    public function requestConfirmed($id){

        return $this->form->requestConfirmed($id, $this->input);

    }
}
