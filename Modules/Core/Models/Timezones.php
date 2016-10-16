<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Timezones extends Model
{
    public $timestamps = false;
    protected $table = 'timezones';
    protected $fillable = ['name', 'location'];
}
