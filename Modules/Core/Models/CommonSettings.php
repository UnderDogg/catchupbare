<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class CommonSettings extends Model
{
    protected $table = 'common_settings';
    protected $fillable = [
        'status', 'option_name', 'option_value', 'optional_field', 'created_at', 'updated_at',
    ];
}
