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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes');
            $table->foreignId('departure_address_id')->constrained('addresses');
            $table->foreignId('arrival_address_id')->constrained('addresses');
            $table->foreignId('user_id')->constrained('users');
            $table->string('booking_type'); // once-off or membership
            $table->string('status'); // awaiting-payment/paid/cancelled
            $table->date('date');
            $table->decimal('base_route_total', 10, 2);
            $table->decimal('upsells_total', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->dateTime('payment_date_time')->nullable();
            $table->string('pf_payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
