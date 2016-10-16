<?php

namespace Modules\Tickets\ModelsUtility;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $table = 'languages';
    protected $fillable = ['name', 'locale'];
}
