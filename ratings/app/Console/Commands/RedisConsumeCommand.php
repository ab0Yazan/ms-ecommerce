<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Common\DataTransferObjects\ProductData;
use App\Common\Enums\Events;
use App\Services\RedisService;
use Illuminate\Console\Command;

class RedisConsumeCommand extends Command
{
    protected $signature = 'redis:consume';
    protected $description = 'Consume events from Redis stream';

    public function handle(
        RedisService $redis,
        CreateProductAction $createProduct,
    ) {
        foreach ($redis->getUnprocessedEvents() as $event) {
            match ($event['type']) {
                Events::PRODUCT_CREATED =>
                    $createProduct->execute(
                        ProductData::fromArray($event['data'])
                    ),
                default => null
            };

            $redis->addProcessedEvent($event);
        }
    }
}
