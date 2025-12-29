<x-layouts.marketing>
    <div class="py-8">
        <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">Payment Cancelled</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="rounded-lg p-6 space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Your payment was not completed.
                        </h3>
                        <p class="text-gray-700">
                            It looks like you cancelled the payment process or it was interrupted.
                        </p>
                        <p class="text-gray-700">
                            If this was a mistake, you can try again or contact our support team for assistance.
                        </p>
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
</x-layouts.marketing>
