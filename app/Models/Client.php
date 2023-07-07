<?php

namespace App\Models;

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
    public function isFollowing($storeId)
    {
        return $this->follows()->where('store_id', $storeId)->exists();
    }
}
