<?php

namespace App\Services;

use App\Common\DataTransferObjects\ProductRatingData;
use App\Common\Events\ProductRatedEvent;
use App\Common\Services\RedisService as BaseRedisService;

class RedisService extends BaseRedisService
{
    public function getServiceName(): string
    {
        return 'ratings';
    }

    public function publishProductRated(ProductRatingData $data): void
    {
        $this->publish(new ProductRatedEvent($data));
    }
}
