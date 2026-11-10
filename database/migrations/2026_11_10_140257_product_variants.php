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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->string('product_slug');

            $table->foreign('product_slug')
                ->references('slug')
                ->on('products')
                ->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();

            $table->decimal('price', 14, 2);
            $table->decimal('compare_at_price', 14, 2)->nullable();
            $table->decimal('cost_price', 14, 2)->nullable();

            $table->string('currency', 3)->default('NGN');

            $table->boolean('track_stock')->default(true);
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->unsignedInteger('reserved_quantity')->default(0);
            $table->boolean('allow_backorder')->default(false);

            $table->string('colour_hex_code')
                ->nullable()
                ->index();

            $table->foreign('colour_hex_code')
                ->references('hex_code')
                ->on('colours')
                ->nullOnDelete();

            $table->foreignId('weight_id')
                ->nullable()
                ->constrained('weights')
                ->nullOnDelete();

            $table->boolean('is_default')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_slug', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
