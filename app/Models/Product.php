<?php

namespace App\Models;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'category_id',
        'store_id',
        'brand_id',
        'image',
        'description',
        'info',
        'ingredients',
        'status',
        'unit',
        'cost_price',
        'price',
        'stock_alert',
        'quantity',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'product_sale');

    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_products')
            ->using(CartProduct::class)
            ->as('cart_products')
            ->withPivot([
                'quantity', 'price', 'name', 'sub_total', 'image',
            ])
        ;

    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->using(OrderProduct::class)
            ->as('order_products')
            ->withPivot([
                'quantity', 'price', 'name', 'sub_total', 'image',
            ])
        ;

    }

    // Helpers
    public function hasSales()
    {
        return $this->sales()->exists();
    }
    public function hasOrders()
    {
        return $this->orders()->exists();
    }
    public function inCarts()
    {
        return $this->carts()->exists();

    }
}
