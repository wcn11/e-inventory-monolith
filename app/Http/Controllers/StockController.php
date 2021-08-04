<?php

namespace App\Http\Controllers;

use App\Codes\Models\StockRequestProcess;
use App\Imports\ProductImport;
use App\Codes\Models\Product;
use App\Codes\Models\StockRequest;
use App\Codes\Models\StockRequestItem;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Codes\Forms\StockOpname\Form;
use App\Codes\Repositories\Product\Repository as ProductRepository;
use App\Codes\Repositories\StockOpname\Repository as StockOpnameRepository;
use App\Codes\Repositories\Stock\Repository as StockRepository;
use App\Codes\Repositories\Limit\Repository as LimitRepository;
use App\Codes\Repositories\StockRequest\Repository as StockRequestRepository;

class StockController extends Controller
{

    protected $request;

    protected $model;

    protected $pdf;

    protected $form;

    protected $input;

    protected $productRepository;

    protected $stockOpnameRepository;

    protected $stockRepository;

    protected $limitRepository;

    protected $stockRequestRepository;
    public function __construct(Request $request, Form $form, Product $model, PDF $pdf, LimitRepository $limitRepository, StockOpnameRepository $stockOpnameRepository, StockRepository $stockRepository, StockRequestRepository $stockRequestRepository, ProductRepository $productRepository)
    {
        $this->request = $request;
        $this->model = $model;
        $this->pdf = $pdf;
        $this->form = $form;
        $this->input = $this->request->all();
        $this->productRepository = $productRepository;
        $this->stockOpnameRepository = $stockOpnameRepository;
        $this->stockRepository = $stockRepository;
        $this->limitRepository = $limitRepository;
        $this->stockRequestRepository = $stockRequestRepository;
    }

    public function builder(): \Illuminate\Database\Query\Builder
    {
        return DB::table('stock_request');
    }
    public function index(Request $request){

        $region = $this->getUserRegion();

        $user = auth()->user()->id;

        $stocks = StockRequest::select('total_stock')->where("user_id", $user)->sum('total_stock');

        return view('pages.stok.index', compact('stocks'));
    }

    public function opname(){

        $recently = $this->stockOpnameRepository->where([
                "user_id" => auth()->user()->id
            ])->
            whereBetween("date", [
                now()->subDays(7), now()
            ])->with("stock_opname_items.product")->get();

        $stock = $this->stockRepository->where(["user_id" => auth()->user()->id])->with('product')->get();

        $stock_limit = $this->limitRepository->where(["user_id" => auth()->user()->id])->with('product')->get(); //ambang batas

        $limits = [];

        foreach ($stock_limit as $limit){

            $data  = collect($stock)->where('product_id', $limit['product_id']);

            if ($data->count() > 0){

                $limit['stock'] = $data->first();

            }else{

                $limit['stock'] = [];

            }

            if (!empty($limit['stock']) && $limit['stock']['total'] < $limit['stock_min']){

                $limit['limit_status'] = false;

            } else if (!empty($limit['stock']) && $limit['stock']['total'] > $limit['stock_min']) {

                $limit['limit_status'] = true;

            }else{

                $limit['limit_status'] = false;

            }

            $limits[] = $limit;

        }

        $stocks['stock'] = $stock;

        $stocks['limits'] = $limits;

        return view('pages.stok.opname.index', ['recently' => $recently, 'stocks' => $stocks]);

    }

    public function upload(Request $request){

        return view('pages.stok.upload-stock');

    }

    public function requestStock(Request $request)
    {

        $stocks = $this->stockRequestRepository->where(["user_id" => auth()->user()->id])->with('stock_request_items')->where(["is_confirmed" => 0])->get();

        $request = StockRequestProcess::where(["user_id" => auth()->user()->id])->with('stock_request_process_items')->get();

        return view('pages.stok.request-stock', compact('stocks', 'request'));

    }

    public function historyRequestStock(Request $request)
    {

        $stocks = $this->stockRequestRepository->where(["user_id" => auth()->user()->id])->with('stock_request_items')->where(["is_confirmed" => 1])->get();

        return view('pages.stok.history-request-stock', compact('stocks'));

    }

    public function storeUpload(Request $request)
    {

        $validator = Validator::make($this->request->all(),[
            'file' => 'mimes:csv,xlsx,xls',
            'origin' => 'required',
            'destination' => 'required',
            'pj' => 'required'
        ], [
            'file.mimes' => 'Format File Tidak Didukung!',
            'origin.required' => 'Asal Harus Diisi!',
            'destination.required' => 'Tujuan Harus Diisi!',
            'pj.required' => 'Penanggung Jawab Harus Diisi!'
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => "Format File Salah Atau Bidang Yang Dibutuhkan Kosong!"
            ], 403);
        }

        try {

            $products = $this->model->all();
            $data = Excel::toArray(new ProductImport(), $this->request->file('file'));

            $tempSKUProduct = [];

            foreach ($products as $p){
                $tempSKUProduct[] = $p->sku;
            }

            foreach ($data[0] as $key => $value) {

                if (empty(strtoupper($value[0]))){
                    continue;
                }

                if (!in_array(strtoupper($value[0]), $tempSKUProduct)) {
                        return response()->json([
                            'success' => false,
                            'message' => "Data Pada Baris " . ($key + 1)  . " Tidak Sesuai Dengan Format Kode Standar!"
                        ], 404);
                }

                if (!is_numeric($value[1])){
                    return response()->json([
                        'success' => false,
                        'message' => "Data Pada Baris " . ($key + 1)  . " Bukan Berupa Angka!"
                    ], 404);
                }
            }

            $totalSKU = [];

            $toSort = collect($data[0])->sort()->values()->all();

            foreach ($tempSKUProduct as $key => $p){

                $index = [
                    'sku' => '',
                    'total' => 0,
                    'weight_per_unit' => 0,
                    'weight' => 0,
                    'product_name' => ''
                ];

                foreach ($toSort as $value) {

                    if (strtolower($p) === strtolower($value[0])){

                        $index = [
                            'product_id' => $products[$key]['id'],
                            'product_name' => $products[$key]['name'],
                            'weight_per_unit' => $products[$key]['weight'],
                            'sku' => $p,
                            'total' => $value[1],
                            'weight' => $products[$key]['weight']
                        ];

                    }
                }

                if (empty($index['sku'])){
                    continue;
                }

                $totalSKU[] = [
                    'product_id' => $index['product_id'],
                    'product_name' => $index['product_name'],
                    'sku' => $index['sku'],
                    'total' => $index['total'],
                    'weight_per_unit' => $index['weight_per_unit'],
                    'total_weight' => $index['weight'] * $index['total']
                ];
            }

            $user = auth()->user()->id;

            $id_stock = strtoupper("BAC-" . substr(md5(uniqid(rand(), true)),0,7));

            $total_weight = 0;
            foreach ($totalSKU as $total){
                $total_weight += $total['total_weight'];
            }

            StockRequest::create([
                'id' => $id_stock,
                'user_id' => $user,
                'total_stock' => collect($totalSKU)->sum('total'),
                'total_weight' => $total_weight,
                'origin' => $this->request['origin'],
                'destination' => $this->request['destination'],
                'date' => now(),
                'pj' => $this->request['pj'],
            ]);

            foreach ($totalSKU as $total){
                StockRequestItem::create([
                    'stock_request_id' => $id_stock,
                    'sku' => $total['sku'],
                    'product_id' => $total['product_id'],
                    'product_name' => $total['product_name'],
                    'total' => $total['total'],
                    'weight' => $total['total_weight'],
                    'weight_per_unit' => $total['weight_per_unit']
                ]);
            }

        }catch (\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => "Terjadi Kesalahan, Silahkan Muat Ulang Atau Coba Lagi Beberapa Saat!"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Stock Jalan Telah Dibuat!",
            'data' => [
                "ID Stock Jalan" => $id_stock
            ]
        ]);
    }

    public function history(){

        $user = auth()->user()->id;

        $history = StockRequest::where("user_id", $user)->orderBy('created_at', 'DESC')->with('stock_request_item')->get();

        return view('pages.stok.history', compact('history'));
    }

    public function downloadPDF($id){

        $this->checkStockTripById($id);

        $history = StockRequest::where("id", $id)->with('stock_request_item')->first();

        $this->pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf = $this->pdf->loadView('pages.stok.download', array('history' =>$history));

        return $pdf->download('invoice ' . $id . '.pdf');
    }

    public function view($id){

        $this->checkStockTripById($id);

        $history = StockRequest::where("id", $id)->with('stock_request_item')->first();

        return view('pages.stok.view', compact('history'));
    }

    public function checkStockTripById($id){

        return StockRequest::findOrFail($id);

    }

    public function checkTrip(Request $request)
    {

        $user = auth()->user()->id;

        $data = StockRequest::where("user_id", $user)->orderBy('created_at', 'DESC')->with('stock_request_item')->get();

        return view('pages.stok.check', compact('data'));
    }

    public function getChartData(){

        try {
            $user = auth()->user()->id;

            $from = $this->request['from'];
            $to = $this->request['to'];
            $data = StockRequest::where("user_id", $user)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'DESC')->with('stock_request_item')->get();

            return response()->json([
                "success" => true,
                "data" => $data
            ]);

        }catch (\Exception $e){
            return response()->json([
                "success" => false,
                "message" => "Terjadi Kesalahan, Silahkan Muat Ulang Halaman!"
            ]);
        }
    }

    public function downloadAsPDF(){
        $file= public_path(). '/berita_acara/BERITA_ACARA_STOK_MANUAL.pdf';

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file, 'BERITA_ACARA_STOK_MANUAL.pdf', $headers);
    }

    public function downloadAsWORD(){
        $file= public_path(). '/berita_acara/BERITA_ACARA_STOK_MANUAL.docx';

        $headers = array(
            'Content-Type: application/docx',
        );

        return response()->download($file, 'BERITA_ACARA_STOK_MANUAL.docx', $headers);
    }

    public function example(){
        $file= public_path(). '/berita_acara/CONTOH_BERITA_ACARA_STOK_MANUAL.pdf';

        $headers = array(
            'Content-Type: application/docx',
        );

        return response()->download($file, 'CONTOH_BERITA_ACARA_STOK_MANUAL.pdf', $headers);
    }

    public function getUserRegion(){

        $user = auth()->user();

        if (isset($user->province[0])){

            return $user->province[0]->name;

        }

        return 0;

    }
}
