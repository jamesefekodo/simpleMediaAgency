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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            $table->string('product_slug');

            $table->foreign('product_slug')
                ->references('slug')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_email')->nullable();

            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('title')->nullable();
            $table->longText('review')->nullable();

            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false);

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index(['product_slug', 'is_approved']);
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
