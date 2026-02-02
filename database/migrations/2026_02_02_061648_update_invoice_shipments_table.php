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
        Schema::table('invoice_shipments', function (Blueprint $table) {
            $table->foreignId('rate_card_version')->nullable()
                ->constrained('rate_card_versions')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_shipments', function (Blueprint $table) {
            $table->dropForeign(['rate_card_version_id']);
            $table->dropColumn('rate_card_version_id');
        });
    }
};
