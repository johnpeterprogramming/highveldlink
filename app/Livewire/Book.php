<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use WireUi\Traits\WireUiActions;

#[Layout('components.layouts.marketing')]
class Book extends Component
{
    use WireUiActions;

    public $timeslots = [
        ['city' => 'Ermelo', 'address' => 'Total, 96 Fourie Street', 'time' => '10am'],
        ['city' => 'Middelburg', 'address' => 'Shell Ultra City Middelburg N4', 'time' => '11:30am'],
        ['city' => 'Pretoria', 'address' => 'Shell Ultra City Middelburg N4', 'time' => '1pm'],
    ];

    public $selected_departure;
    public $selected_return;

    public function rules()
    {
        return [
            'selected_departure' => ['required', Rule::in($this->departure_timeslots)],
            'selected_return' => ['required', Rule::in($this->return_timeslots)],
        ];
    }

    public function book()
    {
        $this->validate();

        $this->notification()->success(
            $title = 'Booking Confirmed',
            $description = 'Your trip has been successfully saved.'
        );

        dd($this->selected_departure, $this->selected_return);
        return $this->redirect(route('register'), navigate: true);
    }

    public function render()
    {
        return view('livewire.book');
    }
}
