<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Services\ImageInterventionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    protected $request;

    protected $imageInterventionService;

    protected $model;

    public function __construct(Request $request, ImageInterventionService $imageInterventionService, Product $model)
    {
        $this->request = $request;
        $this->imageInterventionService = $imageInterventionService;
        $this->model = $model;
    }

    public function builder(): \Illuminate\Database\Query\Builder
    {
        return DB::table('product');
    }

    public function index(Request $request){
        $products = $this->model->with('category')->orderBy('position', 'ASC')->get();

        return view('pages.barang.index', compact('products'));
    }

    public function create(){
        $product = $this->model->max('position');

        $loop = [];

        for ($i = 0;$i < 10; $i++) {
            $loop[] = $product + $i;
        }

        $category = Category::all(['id', 'name']);

        return view('pages.barang.create', compact('loop', 'category'));
    }

    public function edit($id){

        $isExist = $this->isExist($id);

        if (!$isExist) {
            return Redirect::route('barang')->withErrors("product_not_found", 'Produk Berdasarkan ID ' . $id . " Tidak Ditemukan.");
        }

        $product = $this->model->find($id);
        $productMax = $this->model->max('position');

        $looper = [];

        for ($i = 1;$i < 10; $i++) {
            $looper[] = $productMax + $i;
        }

        $numbers = Arr::prepend($looper, (int)$product->position);

        $loop = array_unique($numbers, SORT_NUMERIC);

        $category = Category::all(['id', 'name']);

        return view('pages.barang.update', compact('product', 'loop', 'category'));
    }


    public function store(){
        $validator = Validator::make($this->request->all(), [
            'sku' => 'required',
            'name' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'position' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'is_enable' => '',
            'slug' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'image' => 'required|max:3000',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }

        if ($this->request->file('image')){

            $image = $this->imageInterventionService->store('product', $this->request->file('image'));

            if (!$image['status']) {
                return Redirect::back()->withErrors(['image', $image]);
            }

            $this->request = $this->request->except('image');

            $this->request['image'] = json_encode($image['data']);
        }

        if (! isset($this->request['is_enable'])){
            $this->request['is_enable'] = 'off';
        }

        $this->model->create($this->request);

        return redirect()->route('barang');
    }

    public function update($id)
    {

        $isExist = $this->isExist($id);

        if (!$isExist) {

            session()->flash('product_not_found', `Produk Berdasarkan ID ${$id}  Tidak DItemukan!`);
            return Redirect::route('barang');
        }

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'position' => 'required',
            'description' => 'required',
            'is_enable' => '',
            'price' => 'required',
            'category_id' => 'required',
            'slug' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'image' => 'max:3000',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }

        if ($this->request->has('image')){
            $image = $this->imageInterventionService->update($isExist, 'product');

            if (!$image['status']) {
                return Redirect::back()->withErrors(['image', $image]);
            }

            $this->request = $this->request->except(['image', '_method', '_token']);

            $this->request['image'] = json_encode($image['data']);
        }else{
            $this->request = $this->request->except(['_method', '_token']);
        }

        if (! isset($this->request['is_enable'])){
            $this->request['is_enable'] = 'off';
        }

        Product::where('id', $id)->update($this->request);

        session()->flash('product_updated_status', 'Produk Berhasil Di Perbarui!');

        return redirect()->route('barang');
    }

    public function isExist($id){
        return $this->model->find($id);
    }

    public function destroy($id){

        $isExist = $this->isExist($id);

        if (!$isExist){
            return response()->json(["not_found" => 'Produk Berdasarkan ID ' . $id . 'Tidak Ditemukan.']);
        }

        $this->model->find($id)->delete();

        session()->flash('product_deleted_status', 'Produk Berhasil Di Hapus!');

        return redirect()->route('barang');

    }
}
