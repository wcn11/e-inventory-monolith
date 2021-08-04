<?php

namespace App\Http\Controllers;

use App\Codes\Models\Product;
use App\Services\ImageInterventionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Codes\Forms\Product\Form as Form;


class ProductController extends Controller
{

    protected $request;

    protected $imageInterventionService;

    protected $model;

    protected $form;

    protected $input;

    public function __construct(Request $request, ImageInterventionService $imageInterventionService, Product $model, Form $form)
    {
        $this->request = $request;

        $this->input = $this->request->all();

        $this->imageInterventionService = $imageInterventionService;

        $this->model = $model;

        $this->form = $form;
    }

    public function index(Request $request){

        $products = $this->form->getAll();

        return view('pages.barang.index', compact('products'));

    }

    public function create(){

        $data = $this->form->create();

        return view('pages.barang.create', ['category' => $data['category'], 'loop' => $data['loop']]);

    }

    public function edit($id){

        $data = $this->form->edit($id);

        return view('pages.barang.update', [
            'category' => $data['category'],
            'product' => $data['product'],
            'loop' => $data['loop'],
            'imageURL' => $data['imageURL'],
            'sack' => $data['sack'],
        ]);

    }


    public function store(){

        $data = $this->form->store($this->input, $this->request);

        return redirect()->route('barang');
    }

    public function update($id)
    {

        $data = $this->form->update($id, $this->input, $this->request);

        return redirect()->route('barang');
    }

    public function isExist($id){

        return $this->model->find($id);

    }

    public function destroy($id){

        $product = $this->form->destroy($id);

        return redirect()->route('barang');

    }
}
