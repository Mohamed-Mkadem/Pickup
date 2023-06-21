<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOpeningHour extends Model
{
    use HasFactory;
    protected $fillable = ['store_id', 'day_of_week', 'opening_time', 'closing_time'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
