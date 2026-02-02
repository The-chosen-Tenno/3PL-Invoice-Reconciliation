<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.ss
     */
    
    public function up(): void
    {
        Schema::create('rate_card_versions', function (Blueprint $table) {
            $table->id();
            $table->string('source_file_name');
            $table->string('file_name');
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_card_versions');
    }
};
