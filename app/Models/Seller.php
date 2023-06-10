<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank',
        'account_name',
        'rib',
        'nid',
        'verification',
        'balance',


    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
