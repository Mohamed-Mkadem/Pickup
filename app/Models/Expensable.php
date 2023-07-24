<?php

namespace App\Models;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expensable extends Model
{
    use HasFactory;

    public function expenses()
    {
        return $this->morphMany(Expense::class, 'expensable');
    }
}
