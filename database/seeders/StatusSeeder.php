<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\StatusType;
use App\Models\Status;
use Illuminate\Database\Seeder;

final class StatusSeeder extends Seeder
{
    /**
     *  a list of status to seed
     */
    private const STATUS_LIST = [

        // Users
        ['name' => 'Pendente', 'status_type_id' => StatusType::USERS],
        ['name' => 'Ativo', 'status_type_id' => StatusType::USERS],
        ['name' => 'Suspenso', 'status_type_id' => StatusType::USERS],

        // Orders
        ['name' => 'Analise', 'status_type_id' => StatusType::ORDERS],
        ['name' => 'Em Processo', 'status_type_id' => StatusType::ORDERS],
        ['name' => 'Entregue', 'status_type_id' => StatusType::ORDERS],
        ['name' => 'Cancelado', 'status_type_id' => StatusType::ORDERS],

        // Digital Collection
        ['name' => 'Não Publicado', 'status_type_id' => StatusType::DIGITAL_COLLECTION],
        ['name' => 'Sem associação', 'status_type_id' => StatusType::DIGITAL_COLLECTION],
        ['name' => 'Publicado', 'status_type_id' => StatusType::DIGITAL_COLLECTION],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::STATUS_LIST)->chunk(100)->each(fn ($chuck) => Status::factory()->createMany($chuck));
    }
}
