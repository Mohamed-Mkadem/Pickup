<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'order_id', 'store_id', 'client_id', 'hospitality', 'commitment', 'honesty', 'total', 'feedback', 'anonymous',
    ];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
