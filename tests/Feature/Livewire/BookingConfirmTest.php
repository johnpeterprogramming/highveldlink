<?php

use App\Livewire\BookingConfirm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(BookingConfirm::class)
        ->assertStatus(200);
});
