<?php

namespace App\Models;

use App\Builders\ProductBuilder;
use App\Common\DataTransferObjects\CategoryData;
use App\Common\DataTransferObjects\ProductData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function newEloquentBuilder($query)
    {
        return new ProductBuilder($query);
    }

    public function toData(): ProductData
    {
        return new ProductData(
            $this->id,
            $this->name,
            $this->description,
            $this->price,
            new CategoryData(
                $this->category->id,
                $this->category->name,
            ),
        );
    }
}
