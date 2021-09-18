<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_users_can_have_roles()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertEquals([$role->name], $user->roles()->get()->pluck('name')->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_users_can_have_permissions()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create();
        $user->permissions()->attach($permission->id);

        $this->assertEquals([$permission->name], $user->permissions()->get()->pluck('name')->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_roles_can_have_permissions()
    {
        $role = Role::factory()->create();
        $permission1 = Permission::factory()->create();
        $permission2 = Permission::factory()->create();

        $role->permissions()->attach([$permission1->id, $permission2->id]);

        $this->assertEquals([$permission1->name, $permission2->name], $role->permissions()->get()->pluck('name')->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_permissions_can_be_attached_to_multiple_roles()
    {
        $permission = Permission::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();

        $role1->permissions()->attach($permission->id);
        $role2->permissions()->attach($permission->id);

        $this->assertEquals([$role1->name, $role2->name], $permission->roles()->get()->pluck('name')->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_check_that_a_user_has_a_given_role()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasRole($role->name));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_check_that_a_user_has_a_given_permission()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create();
        $user->permissions()->attach($permission->id);

        $this->assertTrue($user->hasPermission($permission->name));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_have_permissions_from_both_roles_and_individual_permissions()
    {
        $user = User::factory()->create();
        $user->permissions()->attach(Permission::factory()->create()->id);
        $role = Role::factory()->create();
        $role->permissions()->attach(Permission::factory()->create()->id);
        $user->roles()->attach($role->id);

        ddf(
            $user->allPermissions()->toArray()
        );

        $this->assertEquals(Permission::all()->pluck('name')->toArray(), $user->permissions()->get()->pluck('name')->toArray());
    }
}
