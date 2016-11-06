<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketHelpTopic extends Model
{
    protected $table = 'tickethelptopics';
    protected $fillable = [
        'id', 'topic', 'parent_topic', 'custom_form', 'department_id', 'ticketstatus_id', 'ticketpriority_id', 'slaplan_id',
        'thank_page', 'ticket_num_format', 'status', 'type', 'auto_assign', 'auto_response', 'internal_notes'
    ];
}
