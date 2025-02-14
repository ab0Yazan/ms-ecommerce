<?php

namespace App\Services;

use App\Common\DataTransferObjects\ProductData;
use App\DataTransferObjects\CatalogSearchData;
use Illuminate\Support\Collection;

class ProductService
{
    public function __construct(private HttpClient $httpClient)
    {
    }

    /**
     * @return Collection<ProductData>
     */
    public function getProducts(CatalogSearchData $data): Collection
    {
        return $this->httpClient
            ->get('products', $data->toArray())
            ->map(fn (array $product) => ProductData::fromArray($product));
    }
}
