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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            $table->string('product_slug');

            $table->foreign('product_slug')
                ->references('slug')
                ->on('products')
                ->cascadeOnDelete();

            $table->string('path');
            $table->string('alt_text')->nullable();

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            $table->index(['product_slug', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
