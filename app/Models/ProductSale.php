<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSale extends Pivot
{
    use HasFactory;
    protected $table = 'product_sale';
    public $incrementing = true;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'sub_total',
        'price',
        'name',
        'image',
    ];
}
