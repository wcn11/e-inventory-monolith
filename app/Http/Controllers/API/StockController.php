<?php

namespace App\Http\Controllers\API;

use App\Codes\Forms\Stock\Form;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $request;

    protected $stockForm;

    public function __construct(Request $request, Form $form)
    {
        $this->request = $request->all();

        $this->stockForm = $form;
    }

    public function storeUpload(){

        return $this->stockForm->uploadOpname($this->request);

    }
}
