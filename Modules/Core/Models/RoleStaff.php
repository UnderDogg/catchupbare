<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class RoleStaff extends Model
{
    protected $table = "role_staff";

    public function staffrole()
    {
        return $this->belongsTo(Staff::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
