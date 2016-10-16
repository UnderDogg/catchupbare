<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

  protected $fillable =
    [
      'name', 'departmenttype', 'isdefault', 'slaplan_id', 'manager_id'
    ];

/*
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departmenttype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `slaplan_id` int(10) UNSIGNED DEFAULT NULL,
  `manager_id` int(10) UNSIGNED DEFAULT NULL,
  `department_signature` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 **/


}
