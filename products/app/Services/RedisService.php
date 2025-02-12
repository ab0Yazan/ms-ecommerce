<?php

namespace App\Services;

use App\Common\DataTransferObjects\ProductData;
use App\Common\Events\ProductCreatedEvent;
use App\Common\Services\RedisService as BaseRedisService;

class RedisService extends BaseRedisService
{
    public function getServiceName(): string
    {
        return 'products';
    }

    public function publishProductCreated(ProductData $data): void
    {
        $this->publish(new ProductCreatedEvent($data));
    }
}
