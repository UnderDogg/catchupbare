<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Date_format extends Model
{
    public $timestamps = false;
    protected $table = 'date_format';
    protected $fillable = ['id', 'format'];
}
