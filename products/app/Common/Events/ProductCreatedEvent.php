<?php

namespace App\Common\Events;

use App\Common\DataTransferObjects\ProductData;
use App\Common\Enums\Events;

class ProductCreatedEvent extends Event
{
    public string $type = Events::PRODUCT_CREATED;

    public function __construct(public readonly ProductData $data)
    {
    }
}
