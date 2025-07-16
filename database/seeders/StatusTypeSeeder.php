<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\StatusType;
use Illuminate\Database\Seeder;

final class StatusTypeSeeder extends Seeder
{
    /**
     *  a list of a status type to seed
     */
    private const STATUS_TYPE = [
        ['name' => 'Autenticação'],
        ['name' => 'Requisições'],
        ['name' => 'Coleção Digital'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::STATUS_TYPE)->chunk(100)->each(fn ($chunk) => StatusType::factory()->createMany($chunk));
    }
}
