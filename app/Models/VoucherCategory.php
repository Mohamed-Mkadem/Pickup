<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCategory extends Model
{
    use HasFactory;
    protected $table = 'voucher_categories';
    protected $fillable = [
        'name', 'value', 'icon',
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'category_id');
    }
    public function vouchersCount()
    {
        return $this->vouchers()->count();
    }
}
