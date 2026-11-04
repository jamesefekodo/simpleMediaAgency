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
        Schema::create('weights', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 0–1kg, 1–5kg, 5–10kg
            $table->decimal('min_weight', 10, 3)->default(0); // kg
            $table->decimal('max_weight', 10, 3)->nullable(); // null = no upper limit
            // $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['min_weight', 'max_weight']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weights');
    }
};
