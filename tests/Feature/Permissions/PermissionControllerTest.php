<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;

use function Pest\Laravel\seed;

beforeEach(function () {
    // Seed the database to ensure Status records exist
    seed(\Database\Seeders\DatabaseSeeder::class);

    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('user can view permissions index page', function () {
    // Create some test permissions
    Permission::factory()->count(3)->create();

    // Visit the permissions index page
    $response = $this->get(route('permissions.index'));

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the Inertia component
    $response->assertInertia(fn ($assert) => $assert
        ->component('Permissions/Index')
        ->has('permissions')
    );
});

test('user can create a new permission', function () {
    $permissionData = [
        'name' => 'Test Permission',
        'description' => 'Test Permission Description'
    ];

    // Submit the form to create a new permission
    $response = $this->post(route('permissions.store'), $permissionData);

    // Assert the permission was created in the database
    $this->assertDatabaseHas('permissions', [
        'name' => 'Test Permission',
        'slug' => Str::slug('Test Permission'),
        'description' => 'Test Permission Description'
    ]);

    // Assert the user is redirected to the index page with a success message
    $response->assertRedirect(route('permissions.index'));
    $response->assertSessionHas('status', 'Permissão criada com sucesso.');
});

test('user cannot create a permission with duplicate name', function () {
    // Create a permission
    Permission::factory()->create(['name' => 'Existing Permission']);

    // Try to create another permission with the same name
    $response = $this->post(route('permissions.store'), [
        'name' => 'Existing Permission',
        'description' => 'Test Description'
    ]);

    // Assert validation fails
    $response->assertSessionHasErrors('name');
});

test('user can view edit permission page', function () {
    // Create a permission
    $permission = Permission::factory()->create();

    // Visit the edit page
    $response = $this->get(route('permissions.edit', $permission));

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the Inertia component with the permission data
    $response->assertInertia(fn ($assert) => $assert
        ->component('Permissions/Edit')
        ->has('permission', fn ($assert) => $assert
            ->where('id', $permission->id)
            ->where('name', $permission->name)
            ->etc()
        )
    );
});

test('user can update a permission', function () {
    // Create a permission
    $permission = Permission::factory()->create(['name' => 'Old Name']);

    // Update the permission
    $response = $this->patch(route('permissions.update', $permission), [
        'name' => 'New Name',
        'description' => 'Updated Description'
    ]);

    // Refresh the model from the database
    $permission->refresh();

    // Assert the permission was updated in the database
    $this->assertEquals('New Name', $permission->name);
    $this->assertEquals('Updated Description', $permission->description);

    // Assert the user is redirected to the edit page
    $response->assertRedirect(route('permissions.edit', $permission));
});

test('user cannot update a permission with duplicate name', function () {
    // Create two permissions
    Permission::factory()->create(['name' => 'Existing Permission']);
    $permission = Permission::factory()->create(['name' => 'My Permission']);

    // Try to update the second permission with the name of the first
    $response = $this->from(route('permissions.edit', $permission))
                     ->patch(route('permissions.update', $permission), [
                         'name' => 'Existing Permission',
                         'description' => 'Updated Description'
                     ]);

    // Assert validation fails and redirects back
    $response->assertRedirect(route('permissions.edit', $permission));
    $response->assertSessionHasErrors('name');
});

test('user can delete a permission', function () {
    // Create a permission
    $permission = Permission::factory()->create();

    // Delete the permission
    $response = $this->delete(route('permissions.destroy', $permission));

    // Assert the permission was deleted
    $this->assertDatabaseMissing('permissions', [
        'id' => $permission->id
    ]);

    // Assert the user is redirected back with a success message
    $response->assertRedirect();
    $response->assertSessionHas('status', 'Permissão eliminada com sucesso.');
});
