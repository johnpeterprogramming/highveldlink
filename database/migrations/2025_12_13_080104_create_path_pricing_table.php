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
        Schema::create('path_pricing', function (Blueprint $table) {
            $table->foreignId('route_id')->constrained('routes');
            $table->foreignId('departure_address_id')->constrained('addresses');
            $table->foreignId('arrival_address_id')->constrained('addresses');
            $table->decimal('price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('path_pricing');
    }
};
