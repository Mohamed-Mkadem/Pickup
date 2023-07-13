<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{
    use HasFactory;
    protected $table = 'cart_products';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'sub_total',
        'price',
        'name',
        'image',
    ];
}
