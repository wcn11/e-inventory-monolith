<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Product;
use App\StockRequest;
use App\StockRequestItem;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class StockController extends Controller
{

    protected $request;

    protected $model;

    protected $pdf;

    public function __construct(Request $request, Product $model, PDF $pdf)
    {
        $this->request = $request;
        $this->model = $model;
        $this->pdf = $pdf;
    }

    public function builder(): \Illuminate\Database\Query\Builder
    {
        return DB::table('stock_request');
    }

    public function index(Request $request){

        $user = auth()->user()->id;

        $stocks = StockRequest::select('total_stock')->where("user_id", $user)->sum('total_stock');
        return view('pages.stok.index', compact('stocks'));
    }

    public function upload(Request $request){
        return view('pages.stok.upload-stock');
    }

    public function trip(Request $request)
    {
        return view('pages.stok.trip');
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

//          validasi product
            foreach ($data[0] as $key => $value) {

                if (!in_array($value[0], $tempSKUProduct)) {
                        return response()->json([
                            'success' => false,
                            'message' => "Data Pada Baris " . ($key + 1)  . " Tidak Sesuai Dengan Format Kode Standar!"
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
                            'total' => $index['total'] += 1,
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
}
