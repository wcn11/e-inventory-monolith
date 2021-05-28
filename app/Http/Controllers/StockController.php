<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class StockController extends Controller
{

    protected $request;

    protected $model;

    public function __construct(Request $request, Product $model)
    {
        $this->request = $request;
        $this->model = $model;
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

        $this->request->validate([
            'file' => 'mimes:csv,xlsx,xls',
        ]);

        try {

            $products = $this->model->all('sku');
            $data = Excel::toArray(new ProductImport(), $this->request->file('file'));

            if (strtolower(substr(last($data[0])[0], 0, 3)) !== strtolower('KR-')){
                return response()->json([
                    'success' => false,
                    'message' => "Data Tidak Sesuai Dengan Format Kode Standar!"
                ]);
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
                            'index' => $key + 1
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
                        'karung' => $value[0]
                    ];

                    $index = [];

                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Data Pada Baris " . ($key + 1) . " Tidak Sesuai Dengan Format Kode Standar!"
                    ], 404);
                }
            }

        }catch (\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => "Terjadi Kesalahan, Silahkan Muat Ulang Atau Coba Lagi Beberapa Saat!"
            ], 404);
        }

        return response()->json($totalSKU);
    }

    public function checkTrip(Request $request)
    {
        return view('pages.stok.check');
    }
}
