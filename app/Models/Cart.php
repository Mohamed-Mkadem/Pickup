<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['store_id', 'client_id', 'amount'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_products')
            ->using(CartProduct::class)
            ->as('cart_products')
            ->withPivot([
                'quantity', 'price', 'name', 'sub_total', 'image',
            ])
        ;
    }
}
