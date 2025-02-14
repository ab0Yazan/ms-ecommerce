<?php
namespace App\Common\Events;

use App\Common\DataTransferObjects\OrderData;
use App\Common\Enums\Events;

class OrderCreatedEvent extends Event
{
    public string $type = Events::ORDER_CREATED;

    public function __construct(public OrderData $data)
    {
    }
}
