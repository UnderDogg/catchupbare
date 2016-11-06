<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCollaborator extends Model
{
    protected $table = 'ticket_collaborator';
    protected $fillable = [
        'id', 'isactive', 'ticket_id', 'user_id', 'role', 'updated_at', 'created_at',
    ];
}
