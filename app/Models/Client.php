<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Follow;
use App\Models\OrderNote;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vouchers()
    {
        return $this->morphMany(Voucher::class, 'user');
    }
    public function follows()
    {
        return $this->hasMany(Follow::class);
    }
    public function followsCount()
    {
        return $this->follows()->count();
    }
    public function isFollowing($storeId)
    {
        return $this->follows()->where('store_id', $storeId)->exists();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function hasCart($store)
    {
        return $this->carts()->where('store_id', $store->id)->exists();
    }
    // Orders
    public function orders()
    {
        return $this->hasMany(order::class);
    }

    public function ordersCount()
    {
        return $this->orders()->count();
    }
    public function pendingordersCount()
    {
        return $this->orders()->where('status', 'pending')->count();
    }

    public function acceptedOrdersCount()
    {
        return $this->orders()->where('status', 'accepted')->count();
    }

    public function rejectedOrdersCount()
    {
        return $this->orders()->where('status', 'rejected')->count();
    }

    public function readyOrdersCount()
    {
        return $this->orders()->where('status', 'ready')->count();
    }

    public function pickedOrdersCount()
    {
        return $this->orders()->where('status', 'picked')->count();
    }
    public function spentMoney()
    {
        return $this->orders()->where('status', 'picked')->sum('amount');
    }
    public function notes()
    {
        return $this->morphMany(OrderNote::class, 'notable');
    }
}
