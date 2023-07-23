<?php

namespace App\Models;

use App\Models\Attachment;
use App\Models\StatusHistory;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'title',
        'message',
        'status',
    ];
    use HasFactory;
    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }
    public function hasResponses()
    {
        return $this->responses()->exists();
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function hasAttachments()
    {
        return $this->attachments()->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
