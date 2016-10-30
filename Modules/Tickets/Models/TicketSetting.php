<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketSetting extends Model
{
    /* Using Ticket table  */

    protected $table = 'settings_ticket';
    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'num_format', 'num_sequence', 'priority', 'sla', 'help_topic', 'max_open_ticket', 'collision_avoid',
        'captcha', 'status', 'claim_response', 'assigned_ticket', 'answered_ticket', 'agent_mask', 'html', 'client_update', 'max_file_size',
    ];
}
