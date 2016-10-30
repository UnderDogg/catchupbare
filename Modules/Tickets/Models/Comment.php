<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'description',
        'fk_ticket_id',
        'fk_staff_id'
        ];
    protected $hidden = ['remember_token'];

  public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'fk_ticket_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Staff::class, 'fk_staff_id', 'id');
    }
}
