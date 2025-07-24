<?php

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
        Schema::table('digital_objects', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->after('status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digital_objects', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
};
