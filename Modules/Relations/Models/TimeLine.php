<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLine extends model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'timelines';
  protected $fillable = [
    'user_id',
    'text',
    'type',
    'type_id'
  ];
  protected $guarded = ['id'];

  /**
   * Get the staff that the activity belongs to.
   *
   * @return object
   */
  public function ticket()
  {
    return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
  }

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staff_id', 'id');
  }
}
