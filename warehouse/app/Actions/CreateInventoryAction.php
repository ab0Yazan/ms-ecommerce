<?php
namespace App\Actions;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\DataTransferObjects\ProductData;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\RedisService;

class CreateInventoryAction
{
    public function __construct(private readonly RedisService $redisService) {}
    public function execute(Product $product, Warehouse $warehouse, float $quantity): InventoryData
    {
        Inventory::create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => $quantity
        ]);

        $inventoryData = new InventoryData(
            $product->id,
            Inventory::totalQuantity($product)
        );

        $this->redisService->publishInventoryUpdated($inventoryData);
        return $inventoryData;
    }

}
