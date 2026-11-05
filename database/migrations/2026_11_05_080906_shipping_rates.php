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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_zone_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weight_id')->constrained('weights')->cascadeOnDelete();

            $table->decimal('base_fee', 12, 2)->default(0);
            $table->decimal('per_kg_fee', 12, 2)->default(0);

            $table->integer('estimated_days_min')->nullable();
            $table->integer('estimated_days_max')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['shipping_zone_id', 'weight_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
