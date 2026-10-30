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
        Schema::create('basic_system_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('maintenance_mode')->default(false);
            $table->text('app_name')->nullable();
            $table->string('acronym')->nullable();
            $table->string('logo')->nullable();
            $table->text('slogan')->nullable();
            $table->longText('about_us')->nullable();
            $table->text('about_cover_image')->nullable();
            $table->decimal('account_balance', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_system_settings');
    }
};
