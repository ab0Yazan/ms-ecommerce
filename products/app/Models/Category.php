<?php

namespace App\Models;

use App\Common\DataTransferObjects\CategoryData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function toData(): CategoryData
    {
        return new CategoryData($this->id, $this->name);
    }
}
