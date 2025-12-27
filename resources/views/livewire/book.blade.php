<div>
    <!-- Once off panel -->
    <section>
        <article class="flex justify-center mt-8">
            <x-card class="w-200">
                <x-slot name="title">
                    <h2 class="text-2xl font-bold">Choose Timeslot</h2>
                </x-slot>

                <form wire:submit="book" class="px-4">
                    <!-- Specify Date -->
                    <x-datetime-picker
                        wire:model.live="date"
                        label="Select Date"
                        class="my-4"
                        placeholder="We drive on Fridays and Sundays"
                        without-time
                        :disabled-weekdays="[1, 2, 3, 4, 6]"
                        :min="now()"
                        :max="now()->addMonths(2)"
                    />

                    <!-- Departure -->
                    <x-select label="From Location"
                        placeholder="Select Departure Location"
                        class="my-4"
                        :options="$departureAddresses"
                        option-label="name"
                        option-value="value"
                        wire:model.live="selectedDeparture"
                        :disabled="!$date"
                    />

                    <!-- Arrival -->
                    <x-select label="To Location"
                        placeholder="Select Arrival Location"
                        class="my-4"
                        :options="$arrivalAddresses"
                        option-label="name"
                        option-value="value"
                        wire:model.live="selectedArrival"
                        :disabled="!$selectedDeparture"
                    />

                    <x-button type="submit" label="Check Pricing & Confirm Booking" primary/>
                </form>
            </x-card>
        </article>
    </section>
</div>
