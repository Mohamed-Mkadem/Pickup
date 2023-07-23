<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    protected $fillable = [
        'ticket_id',
        'message',
        'user_id',
    ];
    use HasFactory;
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
