<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function hasperm()
    {
        return $this->belongsToMany(PermissionRole::class, 'Permission_role', 'role_id');
    }
}
