<?php
namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Actions\DecreaseInventoryAction;
use App\Common\DataTransferObjects\OrderData;
use App\Common\DataTransferObjects\ProductData;
use App\Common\Enums\Events;
use App\Services\RedisService;
use Illuminate\Console\Command;

class RedisConsumeCommand extends Command
{
    protected $signature = 'redis:consume';
    protected $description = 'Redis Consume';

    public function handle(
        RedisService $redis,
        CreateProductAction $createProduct,
        DecreaseInventoryAction $decreaseInventory
    ) {
        foreach ($redis->getUnprocessedEvents() as $event) {
            match ($event['type']) {
                Events::PRODUCT_CREATED =>
                    $createProduct->execute(
                        ProductData::fromArray($event['data'])
                    ),
                Events::ORDER_CREATED =>
                    $decreaseInventory->execute(
                        OrderData::fromArray($event['data'])
                    ),
                default => null
            };
        }
    }
}
