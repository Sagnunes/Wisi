<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Status;
use App\Helpers\ArrayHelper;
use App\Models\DigitalObject;
use App\Traits\BenchMarkHelper;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class DigitalObjectsImportCommand extends Command
{
    use BenchMarkHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:digital-objects-import-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $this->startBenchmark('digital_objects');
        DB::table('digital_objects')->truncate();

        try {
            $funds = DB::table('funds')
                ->pluck('id', 'acronym')
                ->toArray();

            $digitalObjects = storage_path('app/private/digital_objects.csv');

            $generateRow = (fn ($row): array => [
                'fund_id' => $funds[$row[0]],
                'title' => $row[1],
                'image_thumb' => $row[2],
                'image_derivative' => $row[3],
                'image_name' => $row[4],
                'inventory_number' => $row[5],
                'website_link' => $row[6],
                'status_id' => $row[7] == 0 ? Status::NO_ASSOCIATION : ($row == 1 ? Status::UNPUBLISHED : Status::PUBLISHED),
            ]);
            foreach (ArrayHelper::chunkFile($digitalObjects, $generateRow, 1000) as $chunk) {
                DigitalObject::insert($chunk);
            }
        } catch (Exception $e) {
            $this->error($e::class.' '.Str::of($e->getMessage())->limit()->value());
        }

        $this->endBenchmark('digital_objects');
    }
}
