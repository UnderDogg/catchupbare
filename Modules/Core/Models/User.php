<?php
namespace Modules\Core\Models;

use Fenos\Notifynder\Notifable;
use Illuminate\Notifications\Notifiable;
use Cache;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'password_confirmation', 'remember_token'];


    protected $primaryKey = 'id';

  public function ticketsAssign()
    {
        return $this->hasMany(Ticket::class, 'assigned_to_staff_id', 'id')
        ->where('status_id', 1)
        ->orderBy('deadline', 'asc');
    }

    public function ticketsCreated()
    {
        return $this->hasMany(Ticket::class, 'fk_staff_id_created', 'id')->limit(10);
    }

    public function ticketsCompleted()
    {
        return $this->hasMany(Ticket::class, 'assigned_to_staff_id', 'id')->where('status_id', 2);
    }

    public function ticketsAll()
    {
        return $this->hasMany(Ticket::class, 'assigned_to_staff_id', 'id')->whereIn('status_id', [1, 2]);
    }

    public function leadsAll()
    {
        return $this->hasMany(Lead::class, 'fk_staff_id', 'id');
    }

    public function settings()
    {
        return $this->belongsTo(Settings::class);
    }

    public function relationsAssign()
    {
        return $this->hasMany(Relation::class, 'fk_staff_id', 'id');
    }

    public function userRole()
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id');
    }

    public function department()
    {
        return $this->belongsToMany(Department::class, 'department_staff');
    }

    public function departmentOne()
    {
        return $this->belongsToMany(Department::class, 'department_staff')->withPivot('department_id');
    }

    public function isOnline()
    {
        return Cache::has('employee-is-online-' . $this->id);
    }
}
