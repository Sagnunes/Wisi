<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use App\Services\RolePermissionService;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\seed;

beforeEach(function () {
    // Seed the database to ensure required records exist
    seed(\Database\Seeders\DatabaseSeeder::class);

    // Clear any existing role_permission relationships
    DB::table('role_permission')->truncate();

    $this->rolePermissionService = new RolePermissionService();
});

test('syncPermissions assigns permissions to a role', function () {
    // Create a role and permissions
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(3)->create();
    $permissionIds = $permissions->pluck('id')->toArray();

    // Sync permissions to the role
    $result = $this->rolePermissionService->syncPermissions($role, $permissionIds);

    // Assert that the permissions were attached
    expect($result)->toHaveKey('attached');
    expect($result['attached'])->toHaveCount(3);

    // Verify the role has the correct permissions in the database
    $this->assertDatabaseCount('role_permission', 3);
    foreach ($permissionIds as $permissionId) {
        $this->assertDatabaseHas('role_permission', [
            'role_id' => $role->id,
            'permission_id' => $permissionId
        ]);
    }
});

test('syncPermissions removes previous permissions when syncing new ones', function () {
    // Create a role and initial permissions
    $role = Role::factory()->create();
    $initialPermissions = Permission::factory()->count(3)->create();
    $initialPermissionIds = $initialPermissions->pluck('id')->toArray();

    // First sync with initial permissions
    $this->rolePermissionService->syncPermissions($role, $initialPermissionIds);

    // Create new permissions to sync
    $newPermissions = Permission::factory()->count(2)->create();
    $newPermissionIds = $newPermissions->pluck('id')->toArray();

    // Sync with new permissions (should replace the old ones)
    $result = $this->rolePermissionService->syncPermissions($role, $newPermissionIds);

    // Assert that the old permissions were detached and new ones attached
    expect($result)->toHaveKey('detached');
    expect($result)->toHaveKey('attached');
    expect($result['detached'])->toHaveCount(3);
    expect($result['attached'])->toHaveCount(2);

    // Verify the role has only the new permissions in the database
    $this->assertDatabaseCount('role_permission', 2);
    foreach ($newPermissionIds as $permissionId) {
        $this->assertDatabaseHas('role_permission', [
            'role_id' => $role->id,
            'permission_id' => $permissionId
        ]);
    }

    // Verify the old permissions are no longer associated
    foreach ($initialPermissionIds as $permissionId) {
        $this->assertDatabaseMissing('role_permission', [
            'role_id' => $role->id,
            'permission_id' => $permissionId
        ]);
    }
});

test('attachPermission adds a single permission to a role', function () {
    // Create a role and a permission
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();

    // Attach the permission to the role
    $this->rolePermissionService->attachPermission($role, $permission->id);

    // Verify the permission was attached in the database
    $this->assertDatabaseHas('role_permission', [
        'role_id' => $role->id,
        'permission_id' => $permission->id
    ]);
});

test('detachPermission removes a single permission from a role', function () {
    // Create a role and permissions
    $role = Role::factory()->create();
    $permissions = Permission::factory()->count(3)->create();
    $permissionIds = $permissions->pluck('id')->toArray();

    // First sync all permissions
    $this->rolePermissionService->syncPermissions($role, $permissionIds);

    // Detach one permission
    $permissionToDetach = $permissions->first();
    $this->rolePermissionService->detachPermission($role, $permissionToDetach->id);

    // Verify the permission was detached in the database
    $this->assertDatabaseMissing('role_permission', [
        'role_id' => $role->id,
        'permission_id' => $permissionToDetach->id
    ]);

    // Verify the other permissions are still attached
    $this->assertDatabaseCount('role_permission', 2);
    foreach ($permissions->skip(1) as $permission) {
        $this->assertDatabaseHas('role_permission', [
            'role_id' => $role->id,
            'permission_id' => $permission->id
        ]);
    }
});
