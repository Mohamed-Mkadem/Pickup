<?php

namespace App\Models;

use App\Models\Expense;
use App\Models\Revenue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'amount',
        'no_items',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sale')
            ->using(ProductSale::class)
            ->as('sale_products')
            ->withPivot([
                'quantity', 'price', 'name', 'sub_total', 'image', 'sale_id', 'product_id',
            ])
        ;
    }
    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'revenueable');
    }
  
}
