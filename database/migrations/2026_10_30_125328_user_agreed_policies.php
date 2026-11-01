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
        Schema::create('user_agreed_policies', function (Blueprint $table) {
            $table->id();
            $table->string('username'); // Foreign
            $table->string('policy'); // Foreign
            $table->string('agreement_status');
            $table->date('agreement_date');
            $table->timestamps();


            // Foreign Field
            $table->foreign('username')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('policy')->references('slug')->on('system_policies')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_agreed_policies');
    }
};
