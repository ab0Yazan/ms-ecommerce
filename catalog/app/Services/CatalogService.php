<?php

namespace App\Services;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\DataTransferObjects\ProductData;
use App\DataTransferObjects\CatalogData;
use App\DataTransferObjects\RatingData;
use App\DataTransferObjects\CatalogSearchData;
use Illuminate\Support\Collection;

class CatalogService
{
    public function __construct(
        private ProductService $productService,
        private WarehouseService $warehouseService,
        private RatingService $ratingService
    ) {}

    /**
     * @return Collection<CatalogData>
     */
    public function getCatalog(CatalogSearchData $data): Collection
    {
        $products = $this->productService->getProducts($data);

        if ($products->isEmpty()) {
            return collect([]);
        }

        $ratings = $this->ratingService->getRatings($products);
        $inventories = $this->warehouseService->getAvailableInventories($products);
        $catalog = [];

        foreach ($products as $product) {
            $inventory = $inventories->firstWhere('productId', $product->id);
            $rating = $ratings->firstWhere('productId', $product->id);

            if (!$inventory || $inventory->quantity === 0.0) {
                continue;
            }

            $catalog[] = $this->createData($product, $rating, $inventory);
        }

        return collect($catalog);
    }

    private function createData(
        ProductData $product,
        ?RatingData $rating,
        InventoryData $inventory
    ): CatalogData {
        return new CatalogData(
            $product->id,
            $product->name,
            $product->description,
            $product->price,
            (int) $rating?->averageRating,
            (int) $rating?->numberOfRatings,
            $inventory->quantity,
        );
    }
}
