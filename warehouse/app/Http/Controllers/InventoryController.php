<?php

namespace App\Http\Controllers;

use App\Actions\CreateInventoryAction;
use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Http\Response;

class InventoryController extends Controller
{
    public function store(StoreInventoryRequest $request, CreateInventoryAction $createInventory)
    {
        $inventoryData = $createInventory->execute(
            $request->getProductModel(),
            $request->getWarehouseModel(),
            $request->getQuantity()
        );

        return response([
            'data' => $inventoryData
        ], Response::HTTP_CREATED);
    }
}
