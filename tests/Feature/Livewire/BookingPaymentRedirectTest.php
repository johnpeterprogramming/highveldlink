<?php

use App\Livewire\BookingPaymentRedirect;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(BookingPaymentRedirect::class)
        ->assertStatus(200);
});
