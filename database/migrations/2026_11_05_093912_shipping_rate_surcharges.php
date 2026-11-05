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
        Schema::create('shipping_rate_surcharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_rate_id')->constrained('shipping_rates')->cascadeOnDelete();
            $table->foreignId('shipping_surcharge_id')->constrained('shipping_surcharges')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(
                ['shipping_rate_id', 'shipping_surcharge_id'],
                'shipping_rate_surcharge_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_rate_surcharges');
    }
};
