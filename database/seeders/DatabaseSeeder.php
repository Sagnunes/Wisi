<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Status;
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
            RoleSeeder::class,
        ]);

        $watcher = User::factory()->create([
            'name' => 'The Watcher',
            'email' => 'watcher@madeira.gov.pt',
            'status_id' => Status::ACTIVE,
        ]);
        $watcher->roles()->attach(\App\Enums\Role::WATCHER->value);
    }
}
