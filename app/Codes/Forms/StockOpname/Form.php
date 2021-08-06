<?php

namespace App\Codes\Forms\StockOpname;

use App\Codes\Mappers\Mapper;
use App\Codes\DTO\StockOpname\StockOpname as stockDTO;
use App\Codes\Models\StockOpname;
use App\Codes\Models\StockOpnameItems;
use App\Codes\Models\StockRequestConfirmation;
use App\Codes\Models\StockRequestConfirmationItem;
use App\Codes\Models\StockRequestItem;
use App\Codes\Models\StockRequestProcess;
use App\Codes\Models\StockRequestProcessItem;
use App\Codes\Repositories\StockRequest\Repository as StockRequestRepository;
use App\Codes\Repositories\Product\Repository as ProductRepository;
use App\Codes\Repositories\Sack\Repository as SackRepository;
use App\Codes\Validators\Validator;
use App\Events\StockRequestEvent;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\PDF;
use App\Services\SackImportService;
use App\Codes\Repositories\Stock\Repository  as StockRepository;
use App\Codes\Repositories\User\Repository as UserRepository;

class Form {

    protected $mapper;

    protected $validator;

    protected $productRepository;

    protected $sackRepository;

    protected $sackImportService;

    protected $stockRepository;

    protected $stockOpnameItems;

    protected $stockRequestRepository;

    protected $userRepository;

    protected $pdf;

    public function __construct(
        PDF $pdf,
        Mapper $mapper,
        Validator $validator,
        ProductRepository $productRepository,
        SackRepository $sackRepository,
        SackImportService $sackImportService,
        StockRepository $stockRepository,
        StockOpnameItems $stockOpnameItems,
        StockRequestRepository $stockRequestRepository,
        UserRepository $userRepository
    ){
        $this->pdf = $pdf;

        $this->mapper = $mapper;

        $this->validator = $validator;

        $this->productRepository = $productRepository;

        $this->sackRepository = $sackRepository;

        $this->sackImportService = $sackImportService;

        $this->stockRepository = $stockRepository;

        $this->stockOpnameItems = $stockOpnameItems;

        $this->stockRequestRepository = $stockRequestRepository;

        $this->userRepository = $userRepository;
    }

    public function getProduct(){

        $paginate = $this->request['paginate'] ?? 10;

        if (!empty($this->request['q'])){

            $products = $this->productRepository
                ->where('SKU', 'LIKE', '%' . $this->request['q'] . '%')
                ->orWhere('name', 'LIKE', '%' . $this->request['q'] . '%')
                ->with('sack')
                ->with('category')
                ->orderBy('position', 'ASC')
                ->paginate($paginate);
        }else{

            $products = $this->productRepository->with('category')->with('sack')->orderBy('position', 'ASC')->paginate($paginate);

        }

        return successResponse($products);
    }

    public function opnameStore($input){

        $stockDTO = $this->mapper->filter($input->all(), stockDTO::opnameUploadDTO);

        $validator = $this->validator->valid($stockDTO, stockDTO::opnameUploadRules);

        if (!$validator['status']){

            return errorResponse(['opname_upload_error' => $validator['message']]);

        }

        if($input->has('file')){

            $file = $input->file('file');

            $mimeValidation = collect(['xlsx', 'csv', 'xlx'])->contains($file->getClientOriginalExtension());

            if (!$mimeValidation){

                return errorResponse(['invalid_file' =>'File Tidak Di Dukung!']);
            }

            $excel = Excel::toArray(new ProductImport(), $file)[0];

            $products = $this->productRepository->with('sack')->get();

            $data = [
                "products" =>  $this->sackImportService->process($products, $excel),
                "pj" => $input->pj
            ];

            return successResponse($data);

        }

        return errorResponse("File Tidak Bisa Dibaca");
    }

    public function confirm($input){

        $products = $input->products['products'];

        $pj = $input->products['pj'];

        $realData = [];

        foreach ($products as $product){

            $realData[] = $product[0];

        }

        $data = collect($realData)->sortBy('id')->values()->all();

        $total = [];

        $index = [];

        foreach ($data as $key => $product){

            if (empty($index)){

                $index = [

                    'contents' => (int)$product['contents']['contents'],
                    'total' => 1,
                    "product_id" => $product['id'],
                    "weight_of_sack" => (double)$product['weightSack']['weight']

                ];

                continue;

            }

            if ($index['product_id'] === $product['id']){

                $index['contents'] += $product['contents']['contents'];

                $index['total'] += 1;

                $index["weight_of_sack"] += (double)$product['weightSack']['weight'];

                continue;

            }else{

                $total[] = $index;

            }

            $index = [

                'contents' => (int)$product['contents']['contents'],
                'total' => 1,
                "product_id" => $product['id'],
                "weight_of_sack" => (double)$product['weightSack']['weight']

            ];

            if(collect($realData)->count() === $key +1){

                $total[] = $index;

            }
        }

        $grand_total = [];

        foreach ($total as $sub_total){

            if (empty($grand_total)){

                $grand_total['contents'] = $sub_total['contents'];
                $grand_total['weight_of_sack'] = (double)$sub_total['weight_of_sack'];
                continue;
            }

            $grand_total['contents'] += $sub_total['contents'];
            $grand_total['weight_of_sack'] += (double)$sub_total['weight_of_sack'];

        }

        $grand_total['total_of_sack'] = count($data);

        $stock_opname = StockOpname::create([
            'user_id' => auth()->user()->id,
            'total_stock' => $grand_total['contents'],
            'total_contents' => $grand_total['contents'],
            'total_of_sack' => $grand_total['total_of_sack'],
            'total_weights' => $grand_total['weight_of_sack'],
            'pj' => $pj,
            'date' => now(),
        ]);

        foreach ($total as $index => $total_item){

            $stock_opname_items = $this->stockOpnameItems->create([
                'stock_opname_id' => $stock_opname->id,
                'product_id' => $total_item['product_id'],
                'contents' => $total_item['contents'],
                'total_of_sack' => $total_item['total'],
                'total_weight' => $total_item['weight_of_sack'],
            ]);

            $this->stockOpnameItems->product()->attach($stock_opname_items->id, [
                'stock_opname_items_id' => $stock_opname_items->id,
                'product_id' => $total_item['product_id']
            ]);

            $this->updateStock($total_item['product_id'], $total_item['contents'], $total_item['total'], $total_item['weight_of_sack']);

        }

        session()->flash("stock_uploaded", "Stock Berhasil DiUpdate");

        return successResponse($stock_opname);

    }

    public function process($sjId, $input){

        $sj = $this->stockRequestRepository->findOrFail($sjId);

        $stockDTO = $this->mapper->filter($input, stockDTO::processDTO);

        $validator = $this->validator->valid($stockDTO, stockDTO::processRules);

        if (!$validator['status']){

            return errorResponse(['process_upload_error' => $validator['message']]);

        }

        $process = StockRequestProcess::create([
            "id" => $input['request']['id'],
            "user_id" => $input['request']['user_id'],
            "total_stock" => $input['request']['total_stock'],
            "total_sack" => $input['request']['total_sack'],
            "total_weight" => $input['request']['total_weight'],
            "origin" => $input['request']['origin'],
            "destination" => $input['request']['destination'],
            "date" => now(),
            "pj" => $input['request']['pj'],
        ]);

        foreach ($input['request']['stock_request_items'] as $item){

            StockRequestProcessItem::create([
                'stock_request_process_id' => $process['id'],
                'sku' => $item['sku'],
                'product_name' => $item['product_name'],
                'product_id' => $item['product_id'],
                'total' => $item['total'],
                'price' => $item['price'],
                'sack' => $item['sack'],
                'weight' => $item['weight'],
                'weight_per_unit' => $item['weight_per_unit'],
            ]);

        }

        $sj->update([
            "is_confirmed" => null
        ]);

        return successResponse($process);

    }

    protected function updateStock($productId, $quantity, $totalSack, $totalWeight){

        $stock = $this->stockRepository->where(["user_id" => auth()->user()->id])->where(["product_id" => $productId])->first();

        if (empty($stock)){
            return $this->stockRepository->create([
                "user_id" => auth()->user()->id,
                "product_id" => $productId,
                "total" => $quantity,
                "total_of_sack" => $totalSack,
                "total_weights" => $totalWeight,
            ]);
        }

        return $this->stockRepository->find($stock->id)->update([
            "total" => $quantity + $stock['total'],
            "total_of_sack" => $totalSack + $stock['total_of_sack'],
            "total_weights" => $totalWeight + $stock["total_weights"]
        ]);
    }


//    public function getRequestOrder($input){
//
//        if (!empty($input['sj']) && !empty($input['paginate'])){
//
//            $stock = $this->stockRequestRepository
//                ->where('id', 'LIKE', '%' . $input['sj'] . '%')
//                ->with('stock_request_items')
//                ->orderBy('date', 'ASC')
//                ->paginate($input['paginate']);
//
//            return successResponse($stock);
//
//        }
//
//        $stock = $this->stockRequestRepository
//            ->orderBy('date', 'ASC')
//            ->paginate(10);
//
//        return successResponse($stock);
//
//    }

    public function requestStore($sjId, $input){

        $stockDTO = $this->mapper->filter($input, stockDTO::requestStockDTO);

        $validator = $this->validator->valid($stockDTO, stockDTO::requestStockRules);

        if (!$validator['status']){

            return errorResponse(['stock_request_error' => $validator['message']]);

        }

        $destination = auth()->user()->province[0]['name'];

        $origin = $this->userRepository->find($input['user_id'])->province[0]['name'];

        $id = "BAC-" . $sjId;

        $stockRequest = $this->stockRequestRepository->create([
            'id' => $id,
            'user_id' => $input['user_id'],
            'total_stock' => $input['total_order'],
            'total_weight' => $input['total_weight'],
            'total_sack' => $input['total_sacks'],
            'origin' => $origin,
            'destination' => $destination,
            'date' => now(),
            'pj' => $input['pj'],
        ]);

        foreach ($input['stock'] as $product){

            StockRequestItem::create([
                "stock_request_id" => $stockRequest['id'],
                "sku" => $product['sku'],
                "product_name" => $product['name'],
                "product_id" => $product['id'],
                "total" => $product['total_order'],
                "sack" => $product['total_sack'],
                "weight" => $product['total_weight'],
                "weight_per_unit" => $product['weight'],
            ]);

        }

        event(new StockRequestEvent($input['user_id'],"Permintaan Persediaan Baru"));

        $linkFile = [
                "link" => route('stock.request.download', [
                    $input['user_id'],
                    $stockRequest['id'],
                ]),
            ];

        return successResponse($linkFile);

    }

    public function requestConfirmed($orderId, $input){

        $stockRequest = $this->stockRequestRepository->where("id", $orderId)->first();

        $stockProcess = StockRequestProcess::findOrFail($orderId);

        if (empty($stockRequest)){

            return errorResponse(['request_not_found' => "Surat Jalan " . $input['request']['id'] . " Tidak Ditemukan!"]);

        }

        $stockDTO = $this->mapper->filter($input, stockDTO::requestConfirmDTO);

        $validator = $this->validator->valid($stockDTO, stockDTO::requestConfirmRules);

        if (!$validator['status']){

            return errorResponse(['request_confirm_error' => $validator['message']]);

        }

        $input = $input['request'];

        $data = [];

        foreach ($input['stock_request_process_items'] as $product){

            if (empty($data)){

                $data = [
                    "total" => $product['total'],
                    "sack" => $product['sack'],
                    "weight" => $product['weight'],
                ];

                continue;
            }

            $data = [
                "total" => $data['total'] + $product['total'],
                "sack" => $data['sack'] + $product['sack'],
                "weight" => $data['weight'] + $product['weight'],
            ];

        }

        StockRequestConfirmation::create([
            'id' => $input['id'],
            'user_id' => $input['user_id'],
            'total_stock' => $data['total'],
            'total_weight' => $data['weight'],
            'total_sack' => $data['sack'],
            'origin' => $input['origin'],
            'destination' => $input['destination'],
            'date' => now(),
            'pj' => $input['pj'],
        ]);

        foreach ($input['stock_request_process_items'] as $product){

            StockRequestConfirmationItem::create([
                "stock_request_confirmation_id" => $input['id'],
                "sku" => $product['sku'],
                "product_name" => $product['product_name'],
                "product_id" => $product['product_id'],
                "total" => $product['total'],
                "price" => $product['price'],
                "sack" => $product['sack'],
                "weight" => $product['weight'],
                "weight_per_unit" => $product['weight_per_unit'],

            ]);

        }

        $stockProcess->delete();

        $this->stockRequestRepository->find($input['id'])->update([
            "is_confirmed" => 1
        ]);

        return successResponse();

    }

    public function requestDelete($id){

        $stock = $this->stockRequestRepository->findOrFail($id);

        return successResponse($stock->delete());

    }

}
