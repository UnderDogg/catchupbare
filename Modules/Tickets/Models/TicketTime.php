<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketTime extends Model
{
    protected $table = 'tickets_time';

    protected $fillable = [
        'time',
        'overtime',
        'fk_ticket_id',
        'title',
        'comment',
        'value'
    ];

    protected $hidden = ['remember_token'];

    public function tickets()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }
}
