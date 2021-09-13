<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRolesAndPermissions
{
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * @param $permissionName
     * @return bool
     */
    public function hasPermission(string $permissionName) : bool
    {
        return (bool) $this->permissions()->where('name', $permissionName)->count();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * @param $roleName
     * @return bool
     */
    public function hasRole(string $roleName)  : bool
    {
        return (bool) $this->roles()->where('name', $roleName)->count();
    }
}
