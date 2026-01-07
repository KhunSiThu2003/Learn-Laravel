<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountGifts extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_id',
        'gift_product_id',
        'qty',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'gift_product_id');
    }
}
