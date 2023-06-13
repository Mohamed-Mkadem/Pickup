<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'category_id', 'value', 'status', 'user_id', 'user_type'];

    public function category()
    {
        return $this->belongsTo(VoucherCategory::class, 'category_id');
    }
    public function user()
    {
        return $this->morphTo();
    }
}
