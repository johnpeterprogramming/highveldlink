<div class="min-h-screen bg-gray-50 py-8">
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Trip Details Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Confirm Your Booking</h2>
            </div>

            <div class="p-6 space-y-6">
                <!-- Journey Information -->
                <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Journey Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <x-icon name="map-pin" class="mt-1"/>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Departure</p>
                                <p class="text-base text-gray-900">{{ $this->departureAddress->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <x-icon name="map-pin" class="mt-1"/>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Arrival</p>
                                <p class="text-base text-gray-900">{{ $this->arrivalAddress->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <x-icon name="calendar" class="mt-1"/>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date</p>
                                <p class="text-base text-gray-900">{{ $this->date }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <x-icon name="clock" class="mt-1"/>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Departure Time</p>
                                <p class="text-base text-gray-900">{{ $this->departureTime }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <x-icon name="clock" class="mt-1"/>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Arrival Time</p>
                                <p class="text-base text-gray-900">{{ $this->arrivalTime }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form wire:submit="confirmBooking">
                    <!-- Upsells Section -->
                    <div class="border border-gray-200 rounded-lg p-6 space-y-4">

                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                        <x-input
                            wire:model="name"
                            label="Name"
                            autocomplete="name"
                            placeholder="Jon Doe"
                            name="name"
                        />
                        <x-input
                            wire:model="email"
                            label="Email"
                            autocomplete="email"
                            placeholder="email@example.com"
                            name="email"
                        />
                        <x-input
                            wire:model="phone"
                            label="Phone Number"
                            autocomplete="tel"
                            placeholder="0123456789"
                            name="phone"
                        />


                    </div>

                    <!-- Contact Information Form -->
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add-ons</h3>
                        <div class="space-y-3">
                            <x-checkbox
                                id="direct-dropoff"
                                wire:click="$refresh"
                                wire:model.live="directDropoff"
                                rounded="md"
                                label="Direct Dropoff (R{{ $this->directDropoffUpsell->price }}) - {{ $this->directDropoffUpsell->description }}"
                                value="md"
                                xl
                            />
                            <x-checkbox
                                id="wifi-addon"
                                wire:click="$refresh"
                                wire:model.live="wifi"
                                rounded="md"
                                label="Uncapped WiFi (R{{ $this->wifiUpsell->price }})"
                                value="md"
                                xl
                            />
                        </div>

                        <!-- Price Display -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total Price:</span>
                                <span class="text-2xl font-bold text-blue-600">R{{ $this->price }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="pt-4">
                        <x-button
                            primary
                            type="submit"
                            class="w-full py-3 text-lg"
                            :label="__('Continue To Payment')"
                        />
                    </div>
                </form>

                <!-- When this gets shown it redirects to payfast  -->
                @if ($showPayFastForm)
                    <div wire:ignore x-data x-show="false" x-init="$nextTick(() => document.getElementById('payfast-form').submit())">
                        {!! $payFastForm !!}
                    </div>
                @endif

            </div>
        </div>
    </section>
</div>
