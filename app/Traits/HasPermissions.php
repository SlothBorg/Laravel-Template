<?php

namespace App\Traits;

use App\Models\Permission;

trait HasPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(Permission $permission) : bool
    {
        return (bool) $this->permissions()->where('name', $permission->name)->count();
//        return in_array($permission, $this->getMergedPermissions());
    }

    public function hasPermissions(array $permissions) : bool
    {
        $flag = true;
        foreach ($permissions as $permission) {
            $flag = $flag && $this->hasPermission($permission);
        }
        return $flag;
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
