<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'seller_id', 'status'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
