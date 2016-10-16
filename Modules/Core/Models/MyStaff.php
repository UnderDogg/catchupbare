<?php

namespace App\Models;

use App\Notifications\StaffResetPassword;
use Fenos\Notifynder\Notifable;
use Illuminate\Notifications\Notifiable;
use Cache;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{

    use Notifiable, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "stiffmemore";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_me_token',
    ];

    protected $primaryKey = 'id';

    public function tasksAssign()
    {
        return $this->hasMany(Tasks::class, 'fk_user_id_assign', 'id')
            ->where('status', 1)
            ->orderBy('deadline', 'asc');
    }

    public function tasksCreated()
    {
        return $this->hasMany(Tasks::class, 'fk_user_id_created', 'id')->limit(10);
    }

    public function tasksCompleted()
    {
        return $this->hasMany(Tasks::class, 'fk_user_id_assign', 'id')->where('status', 2);
    }

    public function tasksAll()
    {
        return $this->hasMany(Tasks::class, 'fk_user_id_assign', 'id')->whereIn('status', [1, 2]);
    }

    public function leadsAll()
    {
        return $this->hasMany(Leads::class, 'fk_user_id', 'id');
    }

    public function settings()
    {
        return $this->belongsTo(Settings::class);
    }

    public function clientsAssign()
    {
        return $this->hasMany(Client::class, 'fk_user_id', 'id');
    }

    public function userRole()
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id');
    }

    public function department()
    {
        return $this->belongsToMany(Department::class, 'department_user');
    }

    public function departmentOne()
    {
        return $this->belongsToMany(Department::class, 'department_user')->withPivot('Department_id');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StaffResetPassword($token));
    }
}
