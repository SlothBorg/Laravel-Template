<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRolesAndPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,);
    }

    public function hasPermission(string $permissionName) : bool
    {
        return (bool) $this->permissions()->where('name', $permissionName)->count();
//        return in_array($permission, $this->getMergedPermissions());
    }

    public function getMergedPermissions()
    {
        $permissions = array();
        foreach ($this->getRoles() as $group) {
            $permissions = array_merge($permissions, $group->permissions()->get()->toArray());
        }
        return $permissions;
    }

    public function attachPermission(Permission $permission) : bool
    {
        return $this->permissions()->attach($permission);
    }

    public function detachPermission(Permission $permission) : bool
    {
        return $this->permissions()->detach($permission);
    }

    public function attachPermissions($permissions) : void
    {
        foreach ($permissions as $permission) {
            $this->attachRole($permission);
        }
    }

    public function detachPermissions($permissions) : void
    {
        foreach ($permissions as $permission) {
            $this->detachRole($permission);
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user');
    }

    public function hasRole(string $roleName) : bool
    {
        return (bool) $this->roles()->where('name', $roleName)->count();
    }

    public function attachRole(Role $role) : bool
    {
        return $this->roles()->attach($role);
    }

    public function detachRole(Role $role) : bool
    {
        return $this->roles()->detach($role);
    }

    public function attachRoles($roles) : void
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    public function detachRoles($roles) : void
    {
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }
}
