<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('ride_id')->unsigned();
            $table->char('passenger_id', '9');

            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])
                  ->default('pending');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            // Indices
            $table->index('ride_id');
            $table->index('passenger_id');
            $table->index('status');

            $table->unique(['ride_id', 'passenger_id', 'status'], 'uq_ride_passenger_status_pending');

            // FKs con ON DELETE CASCADE
            $table->foreign('ride_id')
                  ->references('id')
                  ->on('rides')
                  ->onDelete('cascade');

            $table->foreign('passenger_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
