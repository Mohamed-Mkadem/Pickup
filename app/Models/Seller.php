<?php

namespace App\Models;

use App\Models\Transfer;
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

    public function suspendedBalance()
    {
        $suspendedBalance = 0;

        foreach ($this->paymentRequests()->where('status', 'pending')->get() as $paymentRequest) {
            $suspendedBalance += ($paymentRequest->amount + 5); // Five is Fee
        }
        return $suspendedBalance;
    }
    public function paymentsSummary()
    {
        $paymentRequests = $this->paymentRequests;
        $paymentsSummary =
            [
            'pending' => $paymentRequests->where('status', 'pending')->count(),
            'accepted' => $paymentRequests->where('status', 'accepted')->count(),
            'rejected' => $paymentRequests->where('status', 'rejected')->count(),
            'paid' => $paymentRequests->where('status', 'paid')->count(),
        ];
        return $paymentsSummary;
    }
    public function paymentRequests()
    {
        return $this->hasMany(PaymentRequest::class);
    }
    public function paymentRequestsCount()
    {
        return $this->paymentRequests()->count();
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
    public function store()
    {
        return $this->hasOne(Store::class, 'seller_id');
    }
    public function hasStore()
    {
        return $this->store()->exists();
    }
    public function hasPublishedStore()
    {
        return $this->store()->where('status', 'published')->exists();
    }
    public function storesCount()
    {
        return $this->store()->count();
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
}
