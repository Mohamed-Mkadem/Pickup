<?php

namespace App\Models;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'amount', 'client_id', 'store_id', 'no_items',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->using(OrderProduct::class)
            ->as('order_products')
            ->withPivot([
                'quantity', 'price', 'name', 'sub_total', 'image',
            ])
        ;
    }
    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }
}
