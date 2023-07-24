<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenueable extends Model
{
    use HasFactory;

    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'revenueable');
    }
}
