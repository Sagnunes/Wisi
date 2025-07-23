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
        ['name' => 'The Watcher', 'description' => 'É a entidade máxima do sistema, com acesso irrestrito a todas as funcionalidades e informação. ', 'slug' => 'the-watcher'],
        [
            'name' => 'Director',
            'slug' => 'director',
            'description' => 'Administra e supervisiona áreas estratégicas do sistema, com permissões avançadas mas sem acesso irrestrito.',
        ],
        [
            'name' => 'The Collector',
            'slug' => 'the-collector',
            'description' => 'Responsável pela gestão da coleção digital e pelo acesso a fotografias de determinados fundos.',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::ROLE_LIST)->chunk(100)->each(fn ($chuck) => Role::factory()->createMany($chuck));
    }
}
