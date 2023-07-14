<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'note', 'notable_id', 'notable_type',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function notable()
    {
        return $this->morphTo();
    }
}
