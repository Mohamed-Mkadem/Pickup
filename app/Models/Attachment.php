<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'name',
        'path',
        'size',
    ];
    use HasFactory;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
