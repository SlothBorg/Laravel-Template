<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(Permission $permission) : bool
    {
        $hasPermission = False;
        if ((bool) $this->permissions()->where('name', $permission->name)->count()) {
            $hasPermission = true;
        } else {
             $this->roles()->each(function($role) use ($permission, &$hasPermission) {
                if ((bool) $role->permissions()->where('name', $permission->name)->count()) {
                    $hasPermission = true;
                }
            });
        }
        return $hasPermission;
    }

    public function addPermission(Permission $permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function removePermission(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function addPermissions($permissions) : void
    {
        foreach ($permissions as $permission) {
            $this->attachRole($permission);
        }
    }

    public function removePermissions($permissions) : void
    {
        foreach ($permissions as $permission) {
            $this->detachRole($permission);
        }
    }
}
