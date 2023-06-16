<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank',
        'account_name',
        'rib',
        'nid',
        'verification',
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

    public function verificationRequests()
    {
        return $this->hasMany(VerificationRequest::class);
    }
    public function hasPendingVerificationRequest()
    {
        return $this->verificationRequests()->where('status', 'pending')->exists();
    }

    public function hasSentVerificationRequest()
    {
        return $this->verificationRequests()->exists();
    }
    public function verificationRequestsCount()
    {
        return $this->verificationRequests()->count();
    }
    public function isVerified()
    {
        return $this->verification === 'Verified';
    }

    public function getFullNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}
