<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('plate_id', 7)->primary();

            $table->char('driver_id', 9); 

            $table->string('color', 30);
            $table->string('brand', 30);
            $table->string('model', 40);
            $table->year('year');
            $table->integer('seats');

            $table->string('vehicle_picture', 255)->nullable();

            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
