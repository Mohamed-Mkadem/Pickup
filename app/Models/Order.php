<?php

namespace App\Models;

use App\Models\OrderProduct;
use App\Models\PickRequest;
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
    // Notes
    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }

    // Pick requests
    public function pickRequests()
    {
        return $this->hasMany(PickRequest::class);
    }
    public function hasPendingPickRequest()
    {
        return $this->pickRequests()->where('status', 'pending')->exists();
    }

    // Reviews
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function hasReview()
    {
        return $this->review()->exists();
    }
}
