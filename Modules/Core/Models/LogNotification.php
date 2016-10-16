<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class LogNotification extends Model
{
    protected $table = 'log_notification';
    protected $fillable = ['id', 'log'];
}
