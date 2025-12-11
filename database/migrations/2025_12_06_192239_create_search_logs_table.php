<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();

            // FK correcta porque users.id es char(9)
            $table->char('user_id', 9);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('from_location');
            $table->string('to_location');
            $table->unsignedInteger('result_count');
            $table->timestamp('searched_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
