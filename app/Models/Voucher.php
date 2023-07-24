<?php

namespace App\Models;

use App\Models\Expense;
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
    public function expenses()
    {
        return $this->morphMany(Expense::class, 'expensable');
    }
    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'revenueable');
    }
}
