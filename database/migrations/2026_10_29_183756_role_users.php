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
        Schema::create('role_users', function (Blueprint $table) { // pivot table for many-to-many relationship between users and roles
            $table->string('username');

            $table->foreignId('role_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['username', 'role_id']);

            $table->foreign('username')->references('username')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_users');
    }
};
