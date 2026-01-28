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
        Schema::create('invoice_shipments', function (Blueprint $table) {
            $table->id();

            // // FK -> orders (required)
            // $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            // Optional but useful for finding rows / dedupe
            $table->string('tracking_number')->nullable();

            // Rate inputs
            $table->string('carrier', 100);                 // e.g., DHL, UPS
            $table->string('shipping_method', 150)->nullable(); // service level
            $table->string('warehouse', 50)->nullable();    // NV / PA etc (if rates depend on it)

            // Destination / zone inputs
            $table->string('country', 10)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 20)->nullable();

            // Weight / dimensions
            $table->decimal('weight_lb', 10, 3)->nullable();
            $table->decimal('length_in', 10, 2)->nullable();
            $table->decimal('width_in', 10, 2)->nullable();
            $table->decimal('height_in', 10, 2)->nullable();

            // Charged vs expected
            $table->decimal('carrier_fee', 10, 2)->nullable();    // charged by invoice
            $table->decimal('expected_fee', 10, 2)->nullable();   // calculated from rate card
            $table->decimal('fee_diff', 10, 2)->nullable();       // carrier_fee - expected_fee

            // Status enum
            $table->enum('carrier_fee_status', ['unchecked', 'correct', 'overcharged'])
                ->default('unchecked');

            // Everything not needed for validation goes here
            $table->json('raw_data')->nullable();

            $table->timestamps();

            // Indexes that matter
            $table->index('tracking_number');
            $table->index(['carrier', 'shipping_method']);
            $table->index('carrier_fee_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_shipments');
    }
};
