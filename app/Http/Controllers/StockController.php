<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Product;
use App\StockRequest;
use App\StockRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{

    protected $request;

    protected $model;

    public function __construct(Request $request, Product $model)
    {
        $this->request = $request;
        $this->model = $model;
    }

    public function builder(): \Illuminate\Database\Query\Builder
    {
        return DB::table('stock_request');
    }

    public function index(Request $request){
        return view('pages.stok.index');
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
            'destination' => 'required'
        ], [
            'file.mimes' => 'Format File Tidak Didukung!',
            'origin.required' => 'Asal Harus Diisi!',
            'destination.required' => 'Tujuan Harus Diisi!'
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => "Format File Salah Atau Bidang Yang Dibutuhkan Kosong!"
            ], 403);
        }

        try {

            $products = $this->model->all(['id','sku']);
            $data = Excel::toArray(new ProductImport(), $this->request->file('file'));

            if (strtolower(substr(last($data[0])[0], 0, 3)) !== strtolower('KR-')){
                return response()->json([
                    'success' => false,
                    'message' => "Data Tidak Sesuai Dengan Format Kode Standar!"
                ], 403);
            }

            $tempSKUProduct = [];

            foreach ($products as $p){
                $tempSKUProduct[] = $p->sku;
            }

            $index = [];
            $totalSKU = [];

            foreach ($data[0] as $key => $value) {

                if (in_array(strtolower($value[0]), $tempSKUProduct, true)) {

                    if (empty($index)){

                        $index = [
                            'sku' => $value[0] ,
                            'index' => $key + 1,
                        ];
                        continue;
                    }

                } else if (strtolower(substr($value[0], 0, 3)) === strtolower('KR-')) {

                    if (empty($index)){
                        return response()->json([
                            'success' => false,
                            'message' => "Data Pada Baris " . ($key + 1)  . " Tidak Sesuai Dengan Format Kode Standar!"
                        ], 404);
                    }

                    $totalSKU[] = [
                        'total' => ( $key + 1 ) - $index['index'],
                        'sku' => $index['sku'],
                        'sack' => $value[0],
                        'weight' => (double) str_replace('KR-', '', $value[0])
                    ];

                    $index = [];
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Data Pada Baris " . ($key + 1) . " Tidak Sesuai Dengan Format Kode Standar!"
                    ], 403);
                }
            }

            $user = auth()->user()->id;

            $id_stock = strtoupper("BAC-" . substr(md5(uniqid(rand(), true)),0,7));

            $total_weight = 0;
            $total_sack = 0;
            foreach ($totalSKU as $total){
                $total_weight += $total['weight'];
                $total_sack++;
            }

            $stock_request = StockRequest::create([
                'id' => $id_stock,
                'user_id' => $user,
                'total_stock' => collect($totalSKU)->sum('total'),
                'total_sack' => $total_sack,
                'total_weight' => $total_weight,
                'origin' => $this->request['origin'],
                'destination' => $this->request['destination'],
                'date' => now()
            ]);


            foreach ($totalSKU as $total){
                StockRequestItem::create([
                    'stock_request_id' => $id_stock,
                    'sku' => $total['sku'],
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

    public function checkTrip(Request $request)
    {
        return view('pages.stok.check');
    }
}
