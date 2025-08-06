<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

use function Pest\Laravel\seed;

beforeEach(function () {
    // Seed the database to ensure Status records exist
    seed(\Database\Seeders\DatabaseSeeder::class);

    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('user can view roles index page', function () {
    // Create some test roles
    Role::factory()->count(3)->create();

    // Visit the roles index page
    $response = $this->get(route('roles.index'));

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the Inertia component
    $response->assertInertia(fn ($assert) => $assert
        ->component('Roles/Index')
        ->has('roles')
    );
});

test('user can create a new role', function () {
    $roleData = [
        'name' => 'Test Role',
        'description' => 'Test Role Description'
    ];

    // Submit the form to create a new role
    $response = $this->post(route('roles.store'), $roleData);

    // Assert the role was created in the database
    $this->assertDatabaseHas('roles', [
        'name' => 'Test Role',
        'slug' => Str::slug('Test Role'),
        'description' => 'Test Role Description'
    ]);

    // Assert the user is redirected to the index page with a success message
    $response->assertRedirect(route('roles.index'));
    $response->assertSessionHas('status', 'Perfil criado com sucesso');
});

test('user cannot create a role with duplicate name', function () {
    // Create a role
    Role::factory()->create(['name' => 'Existing Role']);

    // Try to create another role with the same name
    $response = $this->post(route('roles.store'), [
        'name' => 'Existing Role',
        'description' => 'Test Description'
    ]);

    // Assert validation fails
    $response->assertSessionHasErrors('name');
});

test('user can view edit role page', function () {
    // Create a role
    $role = Role::factory()->create();

    // Visit the edit page
    $response = $this->get(route('roles.edit', $role));

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the Inertia component with the role data
    $response->assertInertia(fn ($assert) => $assert
        ->component('Roles/Edit')
        ->has('role', fn ($assert) => $assert
            ->where('id', $role->id)
            ->where('name', $role->name)
            ->etc()
        )
    );
});

test('user can update a role', function () {
    // Create a role
    $role = Role::factory()->create(['name' => 'Old Name']);

    // Update the role
    $response = $this->patch(route('roles.update', $role), [
        'name' => 'New Name',
        'description' => 'Updated Description'
    ]);

    // Refresh the model from the database
    $role->refresh();

    // Assert the role was updated in the database
    $this->assertEquals('New Name', $role->name);
    $this->assertEquals('Updated Description', $role->description);

    // Assert the user is redirected to the edit page
    $response->assertRedirect(route('roles.edit', $role));
});

test('user cannot update a role with duplicate name', function () {
    // Create two roles
    Role::factory()->create(['name' => 'Existing Role']);
    $role = Role::factory()->create(['name' => 'My Role']);

    // Try to update the second role with the name of the first
    $response = $this->from(route('roles.edit', $role))
                     ->patch(route('roles.update', $role), [
                         'name' => 'Existing Role',
                         'description' => 'Updated Description'
                     ]);

    // Assert validation fails and redirects back
    $response->assertRedirect(route('roles.edit', $role));
    $response->assertSessionHasErrors('name');
});

test('user can delete a role', function () {
    // Create a role
    $role = Role::factory()->create();

    // Delete the role
    $response = $this->delete(route('roles.destroy', $role));

    // Assert the role was deleted
    $this->assertDatabaseMissing('roles', [
        'id' => $role->id
    ]);

    // Assert the user is redirected back with a success message
    $response->assertRedirect();
    $response->assertSessionHas('status', 'Perfil eliminado com sucesso');
});
