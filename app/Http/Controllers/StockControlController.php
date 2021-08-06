<?php

namespace App\Http\Controllers;

use App\Codes\Models\StockRequestConfirmation;
use App\Codes\Models\StockRequestProcess;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use App\Codes\Repositories\Product\Repository as ProductRepository;
use App\Codes\Repositories\StockRequest\Repository as StockRequestRepository;
use App\Codes\Repositories\Roles\Repository as RoleRepository;
use App\Codes\Repositories\User\Repository as UserRepository;

class StockControlController extends Controller
{

    protected $userRepository;

    protected $roleRepository;

    protected $request;

    protected $pdf;

    protected $input;

    protected $stockRequestRepository;

    protected $productRepository;

    public function __construct(ProductRepository $productRepository, PDF $pdf, Request $request, StockRequestRepository $stockRequestRepository, RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->pdf = $pdf;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->request = $request;
        $this->input = $request->all();
        $this->stockRequestRepository = $stockRequestRepository;
        $this->productRepository = $productRepository;
    }

    public function index(){

        $users = $this->userRepository->role('RPA')->with('stock.product')->get();

        $totalStock = collect($users)->map(function ($value){

            return collect($value->stock)->sum('total');

        })->sum();

        return view('pages.stok.control.index', compact('users', 'totalStock'));

    }

    public function upload($sjId){

        $request = $this->stockRequestRepository->findOrFail($sjId)->with('stock_request_items.products.sack', 'stock_request_items.products.category')->findOrFail($sjId);

        foreach ($request['stock_request_items'] as $key => $product){

            $request['stock_request_items'][$key]['price'] = 0;

            $request['stock_request_items'][$key]['weight'] = 0;

            $request['total_weight'] = 0;

        }

        return view('pages.stok.opname.upload', compact('request'));

    }

    public function request(){

        $stock = $this->stockRequestRepository
            ->where(["is_confirmed" => 0])
            ->orderBy('date', 'ASC')
            ->with("stock_request_items")
            ->get();

        $request = StockRequestProcess::orderBy('date', 'ASC')
            ->with("stock_request_process_items")
            ->get();

        return view('pages.stok.request.index', compact('stock', 'request'));

    }

    public function history(){

        $request = StockRequestConfirmation::orderBy('date', 'ASC')
            ->with("stock_request_confirmation_items")
            ->get();

        return view('pages.stok.request.history', compact('request'));
    }

    public function requestConfirmation($userId, $orderId){

        $request = StockRequestProcess::findOrfail($orderId)->with('stock_request_process_items')->first();

        return view('pages.stok.request.confirmation', compact('request'));

    }

    public function requestOrder($userId){

        $products = $this->productRepository->with('category')->with('sack')->all();

        $user_id = $userId;

        return view('pages.stok.control.request', compact('products', 'user_id'));

    }

    public function downloadRequestStoreFile($userId, $orderId){

        $user = $this->userRepository->find($userId);

        $origin = $user->province->first();

        $destination = auth()->user()->province->first();

        $stockRequest = $this->stockRequestRepository->find($orderId);

        if ($stockRequest['is_confirmed'] === null){

            $stockRequest = StockRequestProcess::find($orderId);
            if (!$stockRequest){
                abort(404);
            }

            $stockRequestItems = $stockRequest->stock_request_process_items;

        }else{

            $stockRequestItems = $stockRequest->stock_request_items;
        }

        $this->pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf = $this->pdf->loadView('pages.stok.control.download_stock_request', array(

            'stockRequest' => $stockRequest,
            'origin' => $origin['name'],
            'destination' => $destination['name'],
            'stockRequestItems' => $stockRequestItems

        ));

        return $pdf->download('invoice ' . $stockRequest['id'] . '.pdf');

    }

    public function downloadHistoryRequest($userId, $orderId){

        $user = $this->userRepository->find($userId);

        $origin = $user->province->first();

        $destination = auth()->user()->province->first();

        $stockRequest = StockRequestConfirmation::findOrFail($orderId);


        $stockRequestItems = $stockRequest->stock_request_confirmation_items;

        $this->pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf = $this->pdf->loadView('pages.stok.control.download_stock_request', array(

            'stockRequest' => $stockRequest,
            'origin' => $origin['name'],
            'destination' => $destination['name'],
            'stockRequestItems' => $stockRequestItems

        ));

        return $pdf->download('invoice ' . $stockRequest['id'] . '.pdf');

    }

}
