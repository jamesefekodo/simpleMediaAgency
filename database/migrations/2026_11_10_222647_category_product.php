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
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();

            $table->string('product_slug');

            $table->foreign('product_slug')
                ->references('slug')
                ->on('products')
                ->cascadeOnDelete();

            $table->string('product_category_slug');

            $table->foreign('product_category_slug')
                ->references('slug')
                ->on('product_categories')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'product_slug',
                'product_category_slug',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
