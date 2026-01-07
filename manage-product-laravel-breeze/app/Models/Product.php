<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;


    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'weight',
        'length',
        'width',
        'height',
        'status',
    ];


    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
