<?php

namespace App\Models;

use App\Models\StoreOpeningHour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
