<?php


namespace App\Services;

use App\Exceptions\SkuNotExist;
use Illuminate\Support\Facades\Cache;

class SackImportService
{

    protected $products;

    protected $product;


    public function process($products, $excel)
    {

        return $this->validate($products, $excel);

    }

    public function validate($products, $excel)
    {

        if (!Cache::has('import')){

            Cache::put("import", $this->products = $products, now()->addMinutes(10));

        }

        $this->products = Cache::get('import');

        $data = [];

        $sku = [];

        foreach ($this->products as $product){

            $sku[] = $product->sku;

        }

        foreach ($excel as $key => $excelData){

            $skuExcelSub = substr($excelData[0], 0 , 5);

            $contentsExcelSub = substr($excelData[0], 5 , 2);

            $weightExcelSub = [
                (float)substr($excelData[0], 7, 2),
                (float)substr($excelData[0], 9, 2),
            ];

            $skuIsExists = $this->checkIfExists($sku, $skuExcelSub, $key + 1);

            $contentsTreshold = $this->checkContents($contentsExcelSub);

            $weightTreshold = $this->checkWeight($weightExcelSub);

            $data[] = [
               collect($this->product)
            ];

            $this->product = array();

        }

        return $data;

    }

    /**
     * @throws SkuNotExist
     */
    protected function checkIfExists($sku, $skuExcelSub, $key)
    {

        if (!collect($sku)->contains($skuExcelSub)){

            Throw new SkuNotExist("Kode SKU: $skuExcelSub Pada Baris: $key Tidak Sesuai Dengan Kode SKU Standar");

        }

        $product = collect($this->products)->where("sku", $skuExcelSub)->first();

        $this->product = $product;

    }

    protected function checkContents($contents)
    {

        $productContents = $this->product->sack[0]->contents;

        $data = [
            'contents' => $contents,
            "status" => false
        ];

        if ((int)$contents === $productContents){

            $data = [
                'contents' => $contents,
                "status" => true
            ];

        }

        $this->product->contents = $data;
    }

    protected function checkWeight($weight)
    {

        $weightSack = (float)"$weight[0].$weight[1]";

        $weightProduct = $this->product->sack[0];

        $data = [
            'weight' => $weightSack,
            "status" => false
        ];

        if ($weightSack >= $weightProduct->weight_min && $weightSack <= $weightProduct->weight_max ){

            $data = [
                'weight' => $weightSack,
                "status" => true
            ];

        }

        $this->product->weightSack = $data;

    }
}
