<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketLittleThread extends Model
{
    protected $table = 'ticketthreads';
    protected $fillable = [
        'id', 'ticket_id', 'ticket_subject', 'ticket_message', 'time', 'poster', 'created_at', 'updated_at',
    ];
}
