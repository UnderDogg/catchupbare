<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class HelpTopic extends Model
{
    protected $table = 'tickethelptopics';
    protected $fillable = [
        'id', 'topic', 'parent_topic', 'custom_form', 'department', 'ticket_status', 'priority',
        'sla_plan', 'thank_page', 'ticket_num_format', 'internal_notes', 'status', 'type', 'auto_assign',
        'auto_response',
    ];
}
