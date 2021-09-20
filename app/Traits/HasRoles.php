<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(Role $role) : bool
    {
        return (bool) $this->roles()->where('name', $role->name)->count();
    }

    public function addRole(Role $role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole(Role $role)
    {
        return $this->roles()->detach($role);
    }

    public function addRoles($roles) : void
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    public function removeRoles($roles) : void
    {
        foreach ($roles as $role) {
            $this->removeRole($role);
        }
    }
}
