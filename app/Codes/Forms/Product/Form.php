<?php

namespace App\Codes\Forms\Product;

use App\Codes\Mappers\Mapper;
use App\Codes\Models\Category;
use App\Codes\Models\Product;
use App\Codes\Repositories\Product\Repository as ProductRepository;
use App\Codes\Repositories\Sack\Sack as SackRepository;
use App\Codes\Validators\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use App\Codes\DTO\Product\DTO as ProductDTO;
use App\Codes\DTO\Sack\DTO as SackDTO;
use App\Services\ImageInterventionService;

class Form {

    protected $productRepository;

    protected $mapper;

    protected $validator;

    protected $imageInterventionService;

    protected $sackRepository;

    public function __construct(

        ProductRepository $productRepository,

        Mapper $mapper,

        Validator $validator,

        ImageInterventionService $imageInterventionService,

        SackRepository $sackRepository

    ){
        $this->productRepository = $productRepository;

        $this->mapper = $mapper;

        $this->validator = $validator;

        $this->imageInterventionService = $imageInterventionService;

        $this->sackRepository = $sackRepository;
    }

    public function getAll(){

        return $this->productRepository->with('category')->with('sack')->orderBy('position', 'ASC')->get();

    }

    public function create(){

        $product = $this->productRepository->max('position');

        $loop = [];

        for ($i = 0;$i < 10; $i++) {
            $loop[] = $product + $i;
        }

        $category = Category::all(['id', 'name']);

        return [
            "category" => $category,
            "loop" => $loop
        ];

    }

    public function edit($id){

        $product = $this->productRepository->findOrFail($id);

        if (!$product) {

            return Redirect::route('barang')->withErrors("product_not_found", 'Produk Berdasarkan ID ' . $id . " Tidak Ditemukan.");

        }

        $productMax = $this->productRepository->max('position');

        $looper = [];

        for ($i = 1;$i < 10; $i++) {
            $looper[] = $productMax + $i;
        }

        $numbers = Arr::prepend($looper, (int)$product->position);

        $loop = array_unique($numbers, SORT_NUMERIC);

        $category = Category::all(['id', 'name']);

        $imageURL = json_decode($product->image, true)['imageURL'];

        if (!isset($imageURL)){

            $imageURL = public_path('/images/blank_thumbnail.jpg');

        }

        $sack = $this->sackRepository->findWhere(["product_id" => $product->id])->first();

        return [
            "category" => $category,
            "product" => $product,
            "loop" => $loop,
            "imageURL" => $imageURL,
            "sack" => $sack
        ];

    }

    public function store($input, $file){

        $stockDTO = $this->mapper->filter($input, ProductDTO::storeDTO);

        $validator = $this->validator->valid($stockDTO, ProductDTO::storeRules);

        if (!$validator['status']){

            return back()->withErrors(['product_store_invalid' => $validator['message']]);

        }

        $sackDTO = $this->mapper->filter($input, SackDTO::storeDTO);

        $sackValidator = $this->validator->valid($sackDTO, SackDTO::storeRules);

        if (!$sackValidator['status']){

            return back()->withErrors(['sack_store_invalid' => $sackValidator['message']]);

        }

        if ($file->file('image')){

            $image = $this->imageInterventionService->store('product', $file->file('image'));

            if (!$image['status']) {

                return Redirect::back()->withErrors(['image', $image]);

            }

            $input = $file->except('image');

            $input['image'] = json_encode($image['data']);
        }

        if (! isset($this->request['is_enable'])){

            $input['is_enable'] = 'off';

        }

        $product = $this->productRepository->create(Arr::except($input, ['contents', 'weight_min', 'weight_max']));

        $sack = Arr::only($input, ['contents', 'weight_min', 'weight_max']);

        return $this->sackRepository->create([
            'product_id' => $product->id,
            'contents' => $sack['contents'],
            'weight_min' => $sack['weight_min'],
            'weight_max' => $sack['weight_max'],
        ]);

    }

    public function update($id, $input, $file){

        $product = $this->isExist($id);

        $stockDTO = $this->mapper->filter($input, ProductDTO::updateDTO);

        $validator = $this->validator->valid($stockDTO, ProductDTO::updateRules);

        if (!$product) {

            session()->flash('product_not_found', `Produk Berdasarkan ID ${$id}  Tidak DItemukan!`);

            return Redirect::route('barang');
        }

        if (!$validator['status']){

            return back()->withErrors(['product_update_invalid' => $validator['message']]);

        }

        $sackDTO = $this->mapper->filter($input, SackDTO::storeDTO);

        $sackValidator = $this->validator->valid($sackDTO, SackDTO::storeRules);

        if (!$sackValidator['status']){

            return back()->withErrors(['sack_update_invalid' => $sackValidator['message']]);

        }

        if ($file->has('image')){
            $image = $this->imageInterventionService->update($product, 'product');

            if (!$image['status']) {
                return Redirect::back()->withErrors(['image', $image]);
            }

            $input = Arr::except($input, ['image', '_method', '_token']);

            $input['image'] = json_encode($image['data']);

        }else{

            $input = Arr::except($input, ['_method', '_token']);

        }

        if (! isset($input['is_enable'])){

            $input['is_enable'] = 'off';

        }

        $inputProduct = Arr::except($input, ['contents', 'weight_min', 'weight_max']);

        Product::where('id', $id)->update($inputProduct);

//        $sack = Arr::only($input, ['contents', 'weight_min', 'weight_max']);
//return Arr::only($input, ['contents', 'weight_min', 'weight_max']);
        $sack = $this->sackRepository->findWhere(["product_id" => $id]);

        if ($sack->count() > 0 ){

            $sack->first()->update(Arr::only($input, ['contents', 'weight_min', 'weight_max']));

        }else{

            $inputSack = Arr::only($input, ['contents', 'weight_min', 'weight_max']);

            $this->sackRepository->create([
                'product_id' => $product->id,
                'contents' => $inputSack['contents'],
                'weight_min' => $inputSack['weight_min'],
                'weight_max' => $inputSack['weight_max'],
            ]);
        }

        session()->flash('product_updated_status', 'Produk Berhasil Di Perbarui!');

        return true;

    }

    public function destroy($id){

        $product = $this->isExist($id);

        if (!$product){

            return back()->withErrors(["product_not_found" => 'Produk Berdasarkan ID ' . $id . 'Tidak Ditemukan.']);

        }

        $this->productRepository->find($id)->delete();

        session()->flash('product_deleted_success', 'Produk Berhasil Di Hapus!');

        return true;

    }

    public function isExist($id){

        return $this->productRepository->findOrFail($id);

    }

}
