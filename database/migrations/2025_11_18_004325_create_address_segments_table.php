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
        Schema::create('address_segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('start_address_id')->constrained('addresses');
            $table->foreignId('end_address_id')->constrained('addresses');
            $table->decimal('distance')->nullable();
            $table->integer('travel_time_minutes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_segments');
    }
};
