<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\seed;

beforeEach(function () {
    // Seed the database to ensure required records exist
    seed(\Database\Seeders\DatabaseSeeder::class);

    // Clear any existing role_user relationships
    DB::table('role_user')->truncate();

    $this->userRepository = new UserRepository(new User());
    $this->userService = new UserService($this->userRepository);
});

test('syncRoles assigns roles to a user', function () {
    // Create a user and roles
    $user = User::factory()->create();
    $roles = Role::factory()->count(3)->create();
    $roleIds = $roles->pluck('id')->toArray();

    // Sync roles to the user
    $result = $this->userService->syncRoles($user, $roleIds);

    // Assert that the roles were attached (result should contain 'attached' keys)
    expect($result)->toHaveKey('attached');
    expect($result['attached'])->toHaveCount(3);

    // Verify the user has the correct roles in the database
    $this->assertDatabaseCount('role_user', 3);
    foreach ($roleIds as $roleId) {
        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $roleId
        ]);
    }
});

test('syncRoles removes previous roles when syncing new ones', function () {
    // Create a user and roles
    $user = User::factory()->create();
    $initialRoles = Role::factory()->count(3)->create();
    $initialRoleIds = $initialRoles->pluck('id')->toArray();

    // First sync with initial roles
    $this->userService->syncRoles($user, $initialRoleIds);

    // Create new roles to sync
    $newRoles = Role::factory()->count(2)->create();
    $newRoleIds = $newRoles->pluck('id')->toArray();

    // Sync with new roles (should replace the old ones)
    $result = $this->userService->syncRoles($user, $newRoleIds);

    // Assert that the old roles were detached and new ones attached
    expect($result)->toHaveKey('detached');
    expect($result)->toHaveKey('attached');
    expect($result['detached'])->toHaveCount(3);
    expect($result['attached'])->toHaveCount(2);

    // Verify the user has only the new roles in the database
    $this->assertDatabaseCount('role_user', 2);
    foreach ($newRoleIds as $roleId) {
        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $roleId
        ]);
    }

    // Verify the old roles are no longer associated
    foreach ($initialRoleIds as $roleId) {
        $this->assertDatabaseMissing('role_user', [
            'user_id' => $user->id,
            'role_id' => $roleId
        ]);
    }
});

test('syncRoles with empty array removes all roles', function () {
    // Create a user and roles
    $user = User::factory()->create();
    $roles = Role::factory()->count(3)->create();
    $roleIds = $roles->pluck('id')->toArray();

    // First sync with roles
    $this->userService->syncRoles($user, $roleIds);

    // Then sync with empty array
    $result = $this->userService->syncRoles($user, []);

    // Assert that all roles were detached
    expect($result)->toHaveKey('detached');
    expect($result['detached'])->toHaveCount(3);

    // Verify the user has no roles in the database
    $this->assertDatabaseCount('role_user', 0);
});
