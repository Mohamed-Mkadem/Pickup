<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'amount',
        'revenueable_type',
        'revenueable_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function revenueable()
    {
        return $this->morphTo();
    }
}
