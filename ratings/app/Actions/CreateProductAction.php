<?php

namespace App\Actions;

use App\Common\DataTransferObjects\ProductData;
use App\Models\Product;

class CreateProductAction
{
    public function execute(ProductData $data): Product
    {
        return Product::create([
            'id' => $data->id,
            'name' => $data->name,
        ]);
    }
}
