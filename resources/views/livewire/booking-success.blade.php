<div class="py-8">
    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Booking Confirmed!</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="rounded-lg p-6 space-y-3">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your booking on {{ $booking->date->toDateString() }} from
                        <span class="text-blue-700">{{ $booking->departureAddress->city }}</span>
                        to
                        <span class="text-blue-700">{{ $booking->arrivalAddress->city }}</span>
                        has been confirmed!
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Departure Time</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Arrival Time</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Departure Location</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Arrival Location</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <tr>
                                    <td class="px-4 py-2 text-gray-900">{{ $booking->departureTime()->toTimeString() }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $booking->arrivalTime()->toTimeString() }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $booking->departureAddress->name }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $booking->arrivalAddress->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 flex items-center space-x-2">
                        <p class="text-gray-700">
                            Please be at <span class="font-semibold">{{ $booking->departureAddress->name }}</span>
                            20 minutes before the departure time.
                        </p>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
