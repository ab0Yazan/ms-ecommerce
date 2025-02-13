<?php

namespace App\Common\DataTransferObjects;

class InventoryData
{
    public function __construct(
        public readonly int $productId,
        public readonly float $quantity,
    ) {}

    /**
     * @param array{productId: int, quantity: float} $data
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['productId'],
            $data['quantity'],
        );
    }
}
