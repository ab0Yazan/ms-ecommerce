<?php

namespace App\Common\Events;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\Enums\Events;

class InventoryUpdatedEvent extends Event
{
    public string $type = Events::INVENTORY_UPDATED;

    public function __construct(public InventoryData $data)
    {
    }
}
