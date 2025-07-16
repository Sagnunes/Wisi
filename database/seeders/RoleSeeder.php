<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

final class RoleSeeder extends Seeder
{
    /**
     * The list of roles to seed.
     */
    private const ROLE_LIST = [
        ['name' => 'Watcher'],
        ['name' => 'Director'],
        ['name' => 'Collector'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::ROLE_LIST)->chunk(100)->each(fn ($chuck) => Role::factory()->createMany($chuck));
    }
}
