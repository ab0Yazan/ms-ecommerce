<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'productId' => $this->product_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'createdAt' => $this->created_at->isoFormat('ll'),
        ];
    }
}
