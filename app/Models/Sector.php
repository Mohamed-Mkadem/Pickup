<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'icon', 'status',
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
    public function storesCount()
    {
        return $this->stores()->count();
    }
}
