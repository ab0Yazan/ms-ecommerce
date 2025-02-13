<?php
namespace App\Services;

use App\Common\DataTransferObjects\InventoryData;
use App\Common\Events\InventoryUpdatedEvent;
use App\Common\Services\RedisService as BaseRedisService;

class RedisService extends BaseRedisService
{
    public function getServiceName(): string
    {
        return 'warehouse';
    }

    public function publishInventoryUpdated(InventoryData $data): void
    {
        $this->publish(new InventoryUpdatedEvent($data));
    }
}
