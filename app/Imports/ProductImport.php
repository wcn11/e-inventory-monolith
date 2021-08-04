<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{

    public function collection(Collection $collection): Collection
    {
        return $collection;
    }
}
