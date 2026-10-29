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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('username')->unique();
            $table->integer('account_type')->default(2); // 0 - admin, 1-staff , 2- customer
            $table->boolean('is_active')->default(false);
            $table->string('photo')->nullable();
            $table->string('phone_1')->unique();
            $table->string('email_1')->unique();
            $table->string('phone_2')->nullable();
            $table->string('email_2')->nullable();

            $table->boolean('require_login_mfa')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('email_verification')->default(false);
            $table->string('email_verification_code')->nullable();
            $table->timestamp('email_verification_code_expires_at')->nullable();
            $table->boolean('admin_privilege')->default(false);
            $table->string('password');
            $table->string('last_seen_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('mfa_verified')->default(false);
            $table->dateTime('login_otp_expires_at')->nullable();
            $table->string('login_otp')->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
