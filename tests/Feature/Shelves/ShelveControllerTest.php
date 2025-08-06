<?php

declare(strict_types=1);

use App\Models\Shelve;
use App\Models\User;
use Illuminate\Support\Str;

use function Pest\Laravel\seed;

beforeEach(function () {
    // Seed the database to ensure Status records exist
    seed(\Database\Seeders\DatabaseSeeder::class);

    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('user can view shelves index page', function () {
    // Create some test shelves
    Shelve::factory()->count(3)->create();

    // Visit the shelves index page
    $response = $this->get(route('shelves.index'));

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the Inertia component
    $response->assertInertia(fn ($assert) => $assert
        ->component('Shelves/Index')
        ->has('shelves')
    );
});

test('user can create a new shelve', function () {
    $shelveData = [
        'name' => 'Test Shelve'
    ];

    // Submit the form to create a new shelve
    $response = $this->post(route('shelves.store'), $shelveData);

    // Assert the shelve was created in the database
    $this->assertDatabaseHas('shelves', [
        'name' => 'Test Shelve',
        'slug' => Str::slug('Test Shelve')
    ]);

    // Assert the user is redirected to the index page with a success message
    $response->assertRedirect(route('shelves.index'));
    $response->assertSessionHas('status', 'Prateleira criada com sucesso.');
});

test('user cannot create a shelve with duplicate name', function () {
    // Create a shelve
    Shelve::factory()->create(['name' => 'Existing Shelve']);

    // Try to create another shelve with the same name
    $response = $this->post(route('shelves.store'), [
        'name' => 'Existing Shelve'
    ]);

    // Assert validation fails
    $response->assertSessionHasErrors('name');
});

test('user can view edit shelve page', function () {
    // Create a shelve
    $shelve = Shelve::factory()->create();

    // Visit the edit page
    $response = $this->get(route('shelves.edit', $shelve));

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the Inertia component with the shelve data
    $response->assertInertia(fn ($assert) => $assert
        ->component('Shelves/Edit')
        ->has('shelve', fn ($assert) => $assert
            ->where('id', $shelve->id)
            ->where('name', $shelve->name)
            ->etc()
        )
    );
});

test('user can update a shelve', function () {
    // Create a shelve
    $shelve = Shelve::factory()->create(['name' => 'Old Name']);

    // Update the shelve
    $response = $this->patch(route('shelves.update', $shelve), [
        'name' => 'New Name'
    ]);

    // Refresh the model from the database
    $shelve->refresh();

    // Assert the shelve was updated in the database
    $this->assertEquals('New Name', $shelve->name);

    // Assert the user is redirected to the edit page
    $response->assertRedirect(route('shelves.edit', $shelve));
});

test('user cannot update a shelve with duplicate name', function () {
    // Create two shelves
    Shelve::factory()->create(['name' => 'Existing Shelve']);
    $shelve = Shelve::factory()->create(['name' => 'My Shelve']);

    // Try to update the second shelve with the name of the first
    $response = $this->from(route('shelves.edit', $shelve))
                     ->patch(route('shelves.update', $shelve), [
                         'name' => 'Existing Shelve'
                     ]);

    // Assert the shelve name was not updated
    $shelve->refresh();
    $this->assertEquals('My Shelve', $shelve->name);

    // Assert validation fails and redirects back
    $response->assertRedirect(route('shelves.edit', $shelve));
    $response->assertSessionHasErrors('name');
});

test('user can delete a shelve', function () {
    // Create a shelve
    $shelve = Shelve::factory()->create();

    // Delete the shelve
    $response = $this->delete(route('shelves.destroy', $shelve));

    // Assert the shelve was soft deleted
    $this->assertSoftDeleted('shelves', [
        'id' => $shelve->id
    ]);

    // Assert the user is redirected back with a success message
    $response->assertRedirect();
    $response->assertSessionHas('status', 'Prateleira eliminada com sucesso.');
});
