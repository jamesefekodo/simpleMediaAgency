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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('brand_slug')
                ->nullable();

            $table->foreign('brand_slug')
                ->references('slug')
                ->on('brands')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->string('sku')->nullable()->unique();
            $table->string('barcode')->nullable()->unique();

            $table->enum('type', ['simple', 'variable'])
                ->default('simple');

            $table->decimal('price', 14, 2)->nullable();
            $table->decimal('compare_at_price', 14, 2)->nullable();
            $table->decimal('cost_price', 14, 2)->nullable();

            $table->string('currency', 3)->default('NGN');

            $table->boolean('track_stock')->default(true);
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->boolean('allow_backorder')->default(false);
            $table->unsignedInteger('low_stock_threshold')->default(0);

            $table->decimal('rating_average', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);

            $table->foreignId('weight_id')
                ->nullable()
                ->constrained('weights')
                ->nullOnDelete();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->timestamp('published_at')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'is_featured']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
