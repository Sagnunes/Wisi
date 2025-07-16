<?php

declare(strict_types=1);

use App\Models\Fund;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('digital_objects', function (Blueprint $table): void {
            $table->id();
            $table->text('title');
            $table->string('image_name');
            $table->string('image_thumb');
            $table->string('image_derivative');
            $table->string('inventory_number')->nullable();
            $table->string('website_link')->nullable();
            $table->foreignIdFor(Fund::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Status::class)->default(App\Enums\Status::UNPUBLISHED)->constrained()->cascadeOnUpdate();

            $table->index('status_id', 'idx_status_id');

            $table->index('image_thumb', 'idx_image_thumb');

            $table->index(['fund_id', 'title', 'inventory_number'], 'idx_fund_title_inventory');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_objects');
    }
};
