<?php

namespace Modules\Tickets\ModelsUtility;

use Illuminate\Database\Eloquent\Model;

class Limit_Login extends Model
{
    protected $table = 'limit_login';
    protected $fillable = ['email', 'ip_address', 'duration', 'attempt_time', 'created_at', 'updated_at'];
}
