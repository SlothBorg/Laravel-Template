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

    public function test_users_can_have_permissions()
    {
        $user = User::factory()->create();

        $permission = Permission::factory()->create();
        $user->addPermission($permission);

        $this->assertTrue($user->hasPermission($permission));
    }

    public function test_users_can_have_permissions_revoked()
    {
        $user = User::factory()->create();

        $permission = Permission::factory()->create();
        $user->addPermission($permission);

        $this->assertTrue($user->hasPermission($permission));

        $user->removePermission($permission);

        $this->assertFalse($user->hasPermission($permission));
    }


    public function test_permissions_can_be_attached_to_multiple_roles()
    {
        $permission = Permission::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();

        $role1->addPermission($permission);
        $role2->addPermission($permission);

        $this->assertTrue($permission->hasRole($role1));
        $this->assertTrue($permission->hasRole($role2));
    }

    public function test_user_can_have_permissions_from_both_roles_and_individual_permissions()
    {
        $user = User::factory()->create();
        $user->addPermission(Permission::factory()->create());
        $role = Role::factory()->create();
        $role->addPermission(Permission::factory()->create());
        $user->addRole($role);

//        ddf(
//            $user->permissions()
//        );

        $this->assertEquals(Permission::all()->pluck('name')->toArray(), $user->permissions()->get()->pluck('name')->toArray());
    }
}
