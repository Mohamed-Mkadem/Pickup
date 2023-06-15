<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\StatusHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'status',
        'photo',
        'nid_front',
        'nid_back',
        'commercial_register',

    ];
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
