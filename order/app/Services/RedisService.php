<?php
namespace App\Services;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\DataTransferObjects\OrderData;
use App\Common\Events\OrderCreatedEvent;
use App\Common\Services\RedisService as BaseRedisService;

class RedisService extends BaseRedisService
{
    public function getServiceName(): string
    {
        return 'order';
    }

    public function publishOrderCreated(OrderData $data): void
    {
        $this->publish(new OrderCreatedEvent($data));
    }
}
