<?php
namespace App\Http\Requests;
use App\Common\Requests\ApiFormRequest;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Validation\Rule;

class StoreInventoryRequest extends ApiFormRequest
{
    public function getProductModel(): Product
    {
        return Product::findOrFail($this->productId);
    }

    public function getWarehouseModel(): Warehouse
    {
        return Warehouse::findOrFail($this->warehouseId);
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getWarehouseId(): int
    {
        return $this->warehouseId;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function rules()
    {
        return [
            "productId" => [
                "required",
                "exists:products,id",
            ],
            "quantity" => "required|numeric",
            "warehouseId" => [
                "required",
                "exists:warehouses,id",
                Rule::unique('inventories', 'warehouse_id')->where(function ($query) {
                    return $query->where('product_id', request('productId'));
                }),
            ],
        ];
    }
}
