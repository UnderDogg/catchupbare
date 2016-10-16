<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'company_name', 'website', 'phone', 'address', 'landing_page', 'offline_page',
        'thank_page', 'logo', 'use_logo',
    ];
}
