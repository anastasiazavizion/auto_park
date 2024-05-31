<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Car;
use App\Models\Driver;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_driver', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Car::class)->constrained('cars');
            $table->foreignIdFor(Driver::class)->constrained('drivers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_driver');
    }
};
