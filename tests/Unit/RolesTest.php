<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_have_a_role()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->addRole($role);

        $this->assertTrue($user->hasRole($role));
    }

    /** @test */
    public function can_add_a_role_to_a_user_with_roles()
    {
        $user = User::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();
        $user->addRole($role1);
        $user->addRole($role2);

        $this->assertTrue($user->hasRole($role1));
        $this->assertTrue($user->hasRole($role2));
    }

    /** @test */
    public function can_remove_a_role_from_a_user()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->addRole($role);

        $this->assertTrue($user->hasRole($role));;
        $user->removeRole($role);

        $this->assertFalse($user->hasRole($role));
    }

    /** @test */
    public function removing_a_role_leaves_other_roles_intact()
    {
        $user = User::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();
        $user->addRoles([$role1, $role2]);

        $user->removeRole($role1);

        $this->assertFalse($user->hasRole($role1));
        $this->assertTrue($user->hasRole($role2));
    }

    /** @test */
    public function roles_can_have_permissions()
    {
        $role = Role::factory()->create();
        $permission1 = Permission::factory()->create();
        $permission2 = Permission::factory()->create();

        $role->permissions()->attach([$permission1->id, $permission2->id]);

        $this->assertEquals([$permission1->name, $permission2->name], $role->permissions()->get()->pluck('name')->toArray());
    }
}
