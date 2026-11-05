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
        Schema::create('shipping_surcharges', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Fragile handling, Fuel levy, Remote area
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->enum('type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('value', 12, 2)->default(0);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_surcharges');
    }
};
