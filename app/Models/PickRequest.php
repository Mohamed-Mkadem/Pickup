<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickRequest extends Model
{
    protected $fillable = ['status', 'order_id'];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
