<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');

            $table->char('driver_id', '9');
            $table->string('vehicle_plate', 7);

            $table->string('name', 80);
            $table->string('origin', 120);
            $table->string('destination', 120);

            $table->dateTime('departure_date');

            $table->decimal('price_per_seat', 10, 2);
            $table->integer('seats_offered');

            $table->enum('status', ['active', 'inactive', 'cancelled', 'completed'])
                  ->default('active');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            // Indices
            $table->index('driver_id');
            $table->index('vehicle_plate');

            // FKs
            $table->foreign('driver_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('vehicle_plate')
                  ->references('plate_id')
                  ->on('vehicles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
