<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StatusTypeSeeder::class,
            StatusSeeder::class,
            FundSeeder::class,
        ]);

        $role = Role::factory()->create([
                'name' => 'The Watcher',
                'slug' => 'the-watcher',
            ]
        );

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'status_id' => Status::ACTIVE,
        ]);

        $user->roles()->attach($role);


    }
}
