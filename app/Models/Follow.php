<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['store_id','client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
