<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_have_permissions()
    {
        $user = User::factory()->create();

        $permission = Permission::factory()->create();
        $user->addPermission($permission);

        $this->assertTrue($user->hasPermission($permission));
    }

    /** @test */
    public function users_can_have_permissions_revoked()
    {
        $user = User::factory()->create();

        $permission = Permission::factory()->create();
        $user->addPermission($permission);

        $this->assertTrue($user->hasPermission($permission));

        $user->removePermission($permission);

        $this->assertFalse($user->hasPermission($permission));
    }

    /** @test */
    public function permissions_can_be_attached_to_multiple_roles()
    {
        $permission = Permission::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();

        $role1->addPermission($permission);
        $role2->addPermission($permission);

        $this->assertTrue($permission->hasRole($role1));
        $this->assertTrue($permission->hasRole($role2));
    }

    /** @test */
    public function user_can_have_permissions_from_both_roles_and_individual_permissions()
    {
        $permission1 = Permission::factory()->create();
        $permission2 = Permission::factory()->create();

        $user = User::factory()->create();
        $user->addPermission($permission1);
        $role = Role::factory()->create();
        $role->addPermission($permission2);
        $user->addRole($role);

        $this->assertTrue($user->hasPermission($permission1));
        $this->assertTrue($user->hasPermission($permission2));
    }
}
