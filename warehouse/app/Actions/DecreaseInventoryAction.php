<?php

namespace App\Actions;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\DataTransferObjects\OrderData;
use App\Exceptions\ProductInventoryExceededException;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\RedisService;
use Illuminate\Support\Facades\DB;

class DecreaseInventoryAction
{
    public function __construct(private readonly RedisService $redis)
    {
    }

    public function execute(OrderData $orderData): void
    {
        DB::transaction(function () use ($orderData) {
            $product = Product::findOrFail($orderData->productId);
            $this->handleInventoryDecrease($product, $orderData->quantity);
            $this->publishInventoryUpdate($product);
        });
    }

    private function handleInventoryDecrease(Product $product, float $quantity): void
    {
        $totalAvailableQuantity = Inventory::totalQuantity($product);
        if ($totalAvailableQuantity < $quantity) {
            throw new ProductInventoryExceededException(
                "There is not enough $product->name in inventory"
            );
        }
        $this->decreaseInventory($product, $quantity);
    }

    private function decreaseInventory(Product $product, float $quantity): void
    {
        $quantityLeft = $quantity;
        foreach ($product->inventories as $inventory) {
            if ($inventory->quantity >= $quantityLeft) {
                $inventory->decrement('quantity', $quantityLeft);
                $this->deleteInventoryIfEmpty($inventory);
                break;
            }
            $quantityLeft -= $inventory->quantity;
            $inventory->delete();
        }
    }

    private function deleteInventoryIfEmpty(Inventory $inventory): void
    {
        if ($inventory->quantity <= 0.0) {
            $inventory->delete();
        }
    }

    private function publishInventoryUpdate(Product $product): void
    {
        $totalQuantity = Inventory::totalQuantity($product);
        $inventoryData = new InventoryData(
            $product->id,
            $totalQuantity
        );
        $this->redis->publishInventoryUpdated($inventoryData);
    }
}
