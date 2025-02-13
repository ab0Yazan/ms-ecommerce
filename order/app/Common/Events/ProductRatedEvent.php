<?php
namespace App\Common\Events;

use App\Common\DataTransferObjects\ProductRatingData;
use App\Common\Enums\Events;

class ProductRatedEvent extends Event
{
    public string $type = Events::PRODUCT_RATED;

    public function __construct(public ProductRatingData $data)
    {
    }
}
