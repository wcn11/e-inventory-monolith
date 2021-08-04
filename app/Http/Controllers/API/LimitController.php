<?php

namespace App\Http\Controllers\API;
use App\Events\LimitChangeEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Codes\Repositories\Limit\Repository as LimitRepository;
use App\Codes\Forms\Limit\Form;
use App\Codes\Repositories\Product\Repository as ProductRepository;

class LimitController extends Controller
{
    protected $request;

    protected $limitRepository;

    protected $form;

    protected $productRepository;

    public function __construct(Form $form, Request $request, LimitRepository $limitRepository, ProductRepository $productRepository)
    {

        $this->form = $form;
        $this->request = $request->all();
        $this->limitRepository = $limitRepository;
        $this->productRepository = $productRepository;
    }

    public function index(){

        $paginate = $this->request['paginate'] ?? 10;

        if (!empty($this->request['q'])){

            $products = $this->productRepository
                ->where('SKU', 'LIKE', '%' . $this->request['q'] . '%')
                ->orWhere('name', 'LIKE', '%' . $this->request['q'] . '%')
                ->with('category')
                ->orderBy('position', 'ASC')
                ->paginate($paginate);
        }else{

            $products = $this->productRepository->with('category')->orderBy('position', 'ASC')->paginate($paginate);

        }

        $limits = $this->limitRepository->where(["user_id" => $this->request['user_id']])->get();

        foreach ($products as $key => $product){

            foreach ($limits as $limit){

                if ($product['id'] === $limit['product_id']){

                    $products[$key]['limits'] =  $limit;
                }

            }

        }

        return successResponse($products);

    }

    public function getProduct(){

        $product = $this->limitRepository->where(["user_id" => $this->request['user_id']])->where(["product_id" => $this->request['product_id']])->get();

        return successResponse($product);

    }

    public function setLimit(){

        return $this->form->setLimit($this->request);

    }

    public function delete($id){

        return $this->form->delete($id);

    }
}
