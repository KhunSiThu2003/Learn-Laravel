<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'percentage',
        'start_date',
        'end_date',
        'status',
    ];

    public function gifts()
    {
        return $this->hasMany(DiscountGifts::class);
    }

}
