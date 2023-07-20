<?php

namespace App\Models;

use App\Models\OrderNote;
use App\Models\StoreOpeningHour;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'sector_id',
        'balance',
        'expiry_date',
        'followers',
        'address',
        'state_id',
        'city_id',
        'status',
        'username',
        'phone',
        'photo',
        'cover_photo',
        'rate',
    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function subscriptionsCount()
    {
        return $this->subscriptions()->count();
    }
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    public function owner()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function getStateCityAttribute()
    {
        return $this->city->state->name . ' - ' . $this->city->name;
    }
    public function openingHours()
    {
        return $this->hasMany(StoreOpeningHour::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function isBanned()
    {
        return $this->status == 'banned';
    }

    // Transfers

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function transfersCount()
    {
        return $this->transfers()->count();
    }
    public function transfersAmount()
    {
        return $this->transfers()->sum('amount');
    }
    // Follows

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }
    public function isFollowing($id)
    {
        return $this->follows()->where('client_id', $id)->exists();
    }

    // Sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function salesCount()
    {
        return $this->sales()->count();
    }
    public function salesToday()
    {
        return $this->sales()->whereDate('created_at', Carbon::today())->count();
    }

    public function salesThisWeek()
    {
        return $this->sales()->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->count();
    }

    public function salesThisMonth()
    {
        return $this->sales()->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)->count();
    }
    // Carts
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Helpers
    public function isPublished()
    {
        return $this->status == 'published';
    }
    // Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
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
    public function suspendedBalance()
    {
        $balance = $this->orders()->whereIn('status', ['accepted', 'ready', 'pending'])->sum('amount');
        return $balance;
    }

    public function allBalance()
    {
        return $this->balance + $this->suspendedBalance();
    }
    // Notes
    public function notes()
    {
        return $this->morphMany(OrderNote::class, 'notable');
    }
}
