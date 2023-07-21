<?php

namespace App\Models;

use App\Models\OrderNote;
use App\Models\Review;
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
    // Reviews

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function updateRate()
    {
        $totalReviews = $this->reviews()->count();
        if ($totalReviews > 0) {
            $totalStars = $this->reviews()->sum('honesty') + $this->reviews()->sum('commitment') + $this->reviews()->sum('hospitality');
            $this->rate = ($totalStars / ($totalReviews * 15)) * 100;
            $this->save();
        }
    }
    public function totalCommitment()
    {
        $totalReviews = $this->reviews()->count();
        $commitment = 0;
        if ($totalReviews > 0) {
            $totalStars = $this->reviews()->sum('commitment');
            $commitment = ($totalStars / ($totalReviews * 5)) * 100;

        }
        return number_format($commitment, 1);
    }
    public function totalHonesty()
    {
        $totalReviews = $this->reviews()->count();
        $honesty = 0;
        if ($totalReviews > 0) {
            $totalStars = $this->reviews()->sum('honesty');
            $honesty = ($totalStars / ($totalReviews * 5)) * 100;

        }
        return number_format($honesty, 1);
    }
    public function totalHospitality()
    {
        $totalReviews = $this->reviews()->count();
        $hospitality = 0;
        if ($totalReviews > 0) {
            $totalStars = $this->reviews()->sum('hospitality');
            $hospitality = ($totalStars / ($totalReviews * 5)) * 100;

        }
        return number_format($hospitality, 1);
    }
    public function reviewsCount()
    {
        return $this->reviews()->count();
    }
}
