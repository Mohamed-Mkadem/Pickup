<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['duration', 'amount', 'store_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
