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
        // Schema::create('products', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('category'); // Foreign
        //     $table->string('name');
        //     $table->decimal('amount', 10, 2);
        //     $table->decimal('shipping_fee', 10, 2)->nullable();
        //     $table->text('description')->nullable();
        //     $table->boolean('is_top_rated')->default(0);
        //     $table->boolean('is_active')->default(0);
        //     $table->string('delivery_period')->nullable();

        //     $table->boolean('purchase_require_message')->default(1);
        //     $table->boolean('require_image_1')->default(0);
        //     $table->boolean('require_image_2')->default(0);


        //     /* Ownership and classification */
        //     $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
        //     $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();

        //     /* Identity */
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->string('sku')->unique();
        //     $table->string('barcode')->nullable();
        //     $table->string('product_code')->nullable();

        //     /* Content */
        //     $table->string('short_description')->nullable();
        //     $table->longText('description')->nullable();
        //     $table->json('features')->nullable();
        //     $table->json('specifications')->nullable();
        //     $table->json('tags')->nullable();

        //     /* Pricing */
        //     $table->decimal('price', 14, 2);
        //     $table->decimal('compare_at_price', 14, 2)->nullable();
        //     $table->decimal('cost_price', 14, 2)->nullable();
        //     $table->decimal('wholesale_price', 14, 2)->nullable();
        //     $table->string('currency', 3)->default('NGN');
        //     $table->boolean('tax_inclusive')->default(false);
        //     $table->decimal('tax_rate', 6, 3)->default(0);

        //     /* Inventory */
        //     $table->integer('stock_quantity')->default(0);
        //     $table->integer('low_stock_threshold')->default(5);
        //     $table->boolean('track_inventory')->default(true);
        //     $table->boolean('allow_backorder')->default(false);
        //     $table->string('stock_status')->default('in_stock'); // in_stock, out_of_stock, preorder

        //     /* Shipping and fulfilment */
        //     $table->decimal('weight', 10, 3)->default(0); // kg
        //     $table->decimal('length', 10, 2)->nullable(); // cm
        //     $table->decimal('width', 10, 2)->nullable(); // cm
        //     $table->decimal('height', 10, 2)->nullable(); // cm
        //     $table->foreignId('shipping_class_id')->nullable()->constrained('shipping_classes')->nullOnDelete();
        //     $table->boolean('requires_shipping')->default(true);
        //     $table->boolean('requires_special_handling')->default(false);
        //     $table->decimal('shipping_fee_override', 12, 2)->nullable();

        //     /* Media */
        //     $table->string('thumbnail')->nullable();
        //     $table->json('gallery')->nullable();
        //     $table->string('video_url')->nullable();

        //     /* Publishing and visibility */
        //     $table->boolean('is_featured')->default(false);
        //     $table->boolean('is_active')->default(true);
        //     $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
        //     $table->timestamp('published_at')->nullable();

        //     /* SEO */
        //     $table->string('meta_title')->nullable();
        //     $table->text('meta_description')->nullable();
        //     $table->json('meta_keywords')->nullable();

        //     /* Metrics */
        //     $table->unsignedBigInteger('views_count')->default(0);
        //     $table->unsignedBigInteger('sales_count')->default(0);
        //     $table->decimal('average_rating', 3, 2)->default(0);
        //     $table->unsignedBigInteger('reviews_count')->default(0);

        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->index(['is_active', 'status']);
        //     $table->index(['category_id', 'brand_id']);
        //     $table->index(['price']);
        //     $table->index(['created_at']);

        //     $table->timestamps();



        //     $table->foreign('category')->references('id')->on('gift_categories')->onUpdate('cascade')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('products');
    }
};
