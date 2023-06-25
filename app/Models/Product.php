<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'category_id',
        'store_id',
        'brand_id',
        'image',
        'description',
        'info',
        'ingredients',
        'status',
        'unit',
        'cost_price',
        'price',
        'stock_alert',
        'quantity',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
