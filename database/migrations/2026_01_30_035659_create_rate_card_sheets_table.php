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
        Schema::create('rate_card_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rate_card_version_id')
                ->constrained('rate_card_versions')
                ->cascadeOnDelete();
            $table->string('sheet_name');
            $table->string('service_code');
            $table->json('data_json');
            $table->json('column_map_json')->nullable();
            $table->timestamps();
            $table->unique(['rate_card_version_id', 'sheet_name']);
            $table->index(['rate_card_version_id', 'service_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_card_sheets');
    }
};
