<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Seeder;

final class FundSeeder extends Seeder
{
    /**
     *  a list of funds to seed
     */
    private const FUND_LIST = [
        ['acronym' => 'ALH', 'name' => 'Alexander Lamont Henderson'],
        ['acronym' => 'JAR', 'name' => 'João Anacleto Rodrigues'],
        ['acronym' => 'ACB', 'name' => 'Aluízio César de Bettencourt'],
        ['acronym' => 'VIC', 'name' => 'Vicente Photographo'],
        ['acronym' => 'PER', 'name' => 'Perestrellos Photographos'],
        ['acronym' => 'CFF', 'name' => 'Carlos Fotógrafia'],
        ['acronym' => 'PHF', 'name' => 'Photo Figueiras'],
        ['acronym' => 'FJB', 'name' => 'Francisco João Barreto'],
        ['acronym' => 'ALB', 'name' => 'Alberto Camacho Brandão'],
        ['acronym' => 'GRM', 'name' => 'Gino Romoli'],
        ['acronym' => 'VVP', 'name' => 'Visconde Vale Paraíso'],
        ['acronym' => 'ACF', 'name' => 'Artur Campos Fotógrafo'],
        ['acronym' => 'CCS', 'name' => 'Charles Courtenay Shaw'],
        ['acronym' => 'JFC', 'name' => 'João Francisco Camacho'],
        ['acronym' => 'JAS', 'name' => 'Joaquim Augusto de Sousa'],
        ['acronym' => 'IVC', 'name' => 'Isabel Vieira de Castro Câmara'],
        ['acronym' => 'VPCT', 'name' => 'Varela Pècurto'],
        ['acronym' => 'RBM', 'name' => 'Rafael Basto Machado'],
        ['acronym' => 'RMG', 'name' => 'Russel Manners Gordon'],
        ['acronym' => 'ANF', 'name' => 'Álvaro Nascimento Figueira'],
        ['acronym' => 'JAP', 'name' => ''],
        ['acronym' => 'JGS', 'name' => ''],
        ['acronym' => 'SFB', 'name' => ''],
        ['acronym' => 'RMA', 'name' => ''],
        ['acronym' => 'HST', 'name' => ''],
        ['acronym' => 'FTS', 'name' => ''],
        ['acronym' => 'ASS', 'name' => ''],
        ['acronym' => 'JBG', 'name' => 'José Luis Brito Gomes'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::FUND_LIST)->chunk(100)->each(fn ($chunk) => Fund::factory()->createMany($chunk));
    }
}
