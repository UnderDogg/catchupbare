<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Relations\Models\Relation;
use Modules\Core\Models\Staff;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class Ticket extends Model
{
    use Taggable;

    protected $table = 'tickets';

/*
`id`,
`ticket_number`,
`subject`,
`relation_id`,
`assigned_to`,
`mailbox_id`,
`dept_id`,
`team_id`,
`ticketstatus_id`,
`priority_id`,
`slaplan_id`,
`tickettype_id`,
`helptopic_id`,
`ticketsource_id`,
`hasflags`,
`flagtype`,
`hashtml`,
`escalationrule_id`,
`autocloserule_id`,
`is_overdue`,
`duedate`,
`is_transferred`,
`transferred_at`,
`isreopened`,
`reopened_at`,
`is_answered`,
`is_deleted`,
`is_closed`,
`closed_at`,
`last_message_at`,
`last_response_at`,
`lastreplier_id`,
`created_at`,
`updated_at`
**/

    protected $fillable = [
        'id', 'ticket_number', 'subject', 'priority_id', 'relation_id', 'assigned_to', 'transferred_at', 'created_at', 'reopened_at', 'deadline_at'
    ];

    protected $dates = ['reopened_at', 'deadline', 'transferred_at', 'closed_at', 'last_message_at', 'last_response_at', 'created_at', 'updated_at'];

    public function assignee()
    {
        return $this->belongsTo(Staff::class, 'assigned_to');
    }

    public function relationAssignee()
    {
        return $this->belongsTo(Relation::class, 'relation_id');
    }

    public function ticketCreator()
    {
        return $this->belongsTo(Staff::class, 'created_staff_id');
    }

    public function thread()
    {
        return $this->hasMany(TicketThread::class, 'ticket_id', 'id');
    }

    // create a virtual attribute to return the days until deadline
    public function getDaysUntilDeadlineAttribute()
    {
        return Carbon\Carbon::now()
            ->startOfDay()
            ->diffInDays($this->deadline, false); // if you are past your deadline, the value returned will be negative.
    }

    public function settings()
    {
        return $this->hasMany(Settings::class);
    }

    public function time()
    {
        return $this->hasOne(TicketTime::class, 'fk_ticket_id', 'id');
    }

    public function allTime()
    {
        return $this->hasMany(TicketTime::class, 'fk_ticket_id', 'id');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class, 'type_id', 'id')->where('type', 'ticket');
    }
}
