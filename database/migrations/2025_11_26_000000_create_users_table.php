<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // PK
            $table->char('id', '9')->primary();

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('birth_date');

            $table->string('email', 100)->unique();
            $table->string('phone_number', 20);
            $table->string('profile_photo', 255)->nullable();

            $table->string('password', 255);
            $table->string('user_type', 40);

            $table->enum('status', ['active', 'inactive', 'pending'])
                  ->default('pending');

            $table->dateTime('email_verified_at')->nullable();

            $table->char('verify_token_hash', 64)->nullable()->unique();
            $table->dateTime('verify_token_expires_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
