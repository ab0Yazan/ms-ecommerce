<?php

namespace App\Services;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\DataTransferObjects\ProductData;
use Illuminate\Support\Collection;

class WarehouseService
{
    public function __construct(private readonly HttpClient $httpClient)
    {
    }

    /**
     * @param Collection<ProductData> $products
     * @return Collection<InventoryData>
     */
    public function getAvailableInventories(Collection $products): Collection
    {
        return $this->httpClient
            ->get('inventory/products', [
                'productIds' => $products->pluck('id')->toArray()
            ])
            ->map(fn (array $inventory) => new InventoryData(...$inventory));
    }
}
