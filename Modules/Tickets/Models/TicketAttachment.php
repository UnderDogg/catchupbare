<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $table = 'ticket_attachments';
    protected $fillable = [
        'id', 'thread_id', 'name', 'size', 'type', 'file', 'data', 'poster', 'updated_at', 'created_at',
    ];
}
