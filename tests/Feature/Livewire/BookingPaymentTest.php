<?php

use App\Livewire\BookingPayment;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(BookingPayment::class)
        ->assertStatus(200);
});
