<?php

declare(strict_types=1);

use App\Models\Fund;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('digital_objects', function (Blueprint $table): void {
            $table->id();
            $table->mediumText('title');
            $table->string('image_name');
            $table->string('image_thumb');
            $table->string('image_derivative');
            $table->string('inventory_number')->nullable();
            $table->string('website_link')->nullable();
            $table->foreignIdFor(Fund::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Status::class)->nullable()->default(App\Enums\Status::UNPUBLISHED)->constrained()->cascadeOnUpdate();

            $table->index('status_id', 'idx_status_id');

            $table->index('image_thumb', 'idx_image_thumb');
        });

        Illuminate\Support\Facades\DB::statement('CREATE INDEX idx_fund_title_inventory ON digital_objects (fund_id, title(100), inventory_number(100))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_objects');
    }
};
