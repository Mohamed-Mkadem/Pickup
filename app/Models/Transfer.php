<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id', 'store_id', 'amount'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
