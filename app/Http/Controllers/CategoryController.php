<?php

namespace App\Http\Controllers;

use App\Services\ImageInterventionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Codes\Models\Category;

class CategoryController extends Controller
{

    protected $request;

    protected $imageInterventionService;

    protected $model;

    public function __construct(Request $request, ImageInterventionService $imageInterventionService, category $model)
    {
        $this->request = $request;
        $this->imageInterventionService = $imageInterventionService;
        $this->model = $model;
    }

    public function builder(): \Illuminate\Database\Query\Builder
    {
        return DB::table('categories');
    }

    public function index(){
        $categories = $this->model->all();

        return view('pages.kategori.index')->with('categories', $categories);
    }

    public function create(){
        $category = $this->model->max('position');

        $loop = [];

        for ($i = 0;$i < 10; $i++) {
            $loop[] = $category + $i;
        }

        return view('pages.kategori.create', compact('loop'));
    }

    public function edit($id){
        $category = $this->model->find($id);
        $categoryMax = $this->model->max('position');

        $looper = [];

        for ($i = 0;$i < 10; $i++) {
            $looper[] = $categoryMax + $i;
        }

        $numbers = Arr::prepend($looper, (int)$category->position);

        $loop = array_unique($numbers, SORT_NUMERIC);

        return view('pages.kategori.update', compact('category', 'loop'));
    }

    public function store(){
        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'position' => 'required',
            'description' => 'required',
            'is_enable' => 'required',
            'slug' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'image' => 'required|max:3000',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }


        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }

        if ($this->request->file('image')){

            $image = $this->imageInterventionService->store('categories', $this->request->file('image'));

            if (!$image['status']) {
                return Redirect::back()->withErrors(['image', $image]);
            }

            $this->request = $this->request->except('image');

            $this->request['image'] = json_encode($image['data']);
        }

        if (! isset($this->request['is_enable'])){
            $this->request['is_enable'] = 'off';
        }

        $categories = $this->model->create($this->request);

        return redirect()->route('kategori');
    }

    public function update($id){

        $isExist = $this->isExist($id);

        if (!$isExist){
            return Redirect::back()->withErrors("not_found", 'Kategori Berdasarkan ID ' . $id . " Tidak Ditemukan.");
        }

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'position' => 'required',
            'description' => 'required',
            'is_enable' => '',
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
            $image = $this->imageInterventionService->update($isExist);

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

        Category::where('id', $id)->update($this->request);

        session()->flash('category_updated_status', 'Kategori Berhasil Di Perbarui!');

        return redirect()->route('kategori');
    }

    public function isExist($id){
        return $this->model->find($id);
    }

    public function destroy($id){

        $isExist = $this->isExist($id);

        if (!$isExist){
            session()->flash("not_found", 'Kategori Berdasarkan ID ' . $id . 'Tidak Ditemukan.');
            return Redirect::route('kategori');
        }

        if ($isExist->product){
            session()->flash("category_cant_delete", 'Tidak Bisa Menghapus! Ada Produk Tersedia Berdasarkan kategori Ini.');
            return Redirect::route('kategori');
        }

        $this->model->find($id)->delete();

        session()->flash('category_deleted_status', 'Kategori Berhasil Di Hapus!');

        return redirect()->route('barang');

    }
}
