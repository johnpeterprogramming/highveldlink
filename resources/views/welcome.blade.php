<x-layouts.marketing>

    <!--  Landing  -->
    <heading class="container p-8 mx-auto xl:px-0 flex flex-wrap">

        <div class="flex items-center w-full lg:w-1/2">
          <div class="max-w-2xl mb-8">
            <h1 class="text-4xl font-bold leading-snug tracking-tight text-gray-800 lg:text-4xl lg:leading-tight xl:text-6xl xl:leading-tight dark:text-white">
                Safe Student Lift
            </h1>
            <p class="py-5 text-xl leading-normal text-gray-500 lg:text-xl xl:text-2xl dark:text-gray-300">Safe, private rides from Mpumalanga to Gauteng universities – because your parents' peace of mind matters as much as yours.</p>

            <div class="flex flex-col items-start space-x-3 space-y-3 sm:space-y-0 sm:items-center sm:flex-row">
              <a
                href="{{ route('book') }}"
                target="_blank"
                rel="noopener"
                class="px-8 py-4 text-lg font-medium text-center text-white bg-indigo-600 rounded-md ">
                Book Now
              </a>

            </div>
          </div>
        </div>
        <div class="flex items-center justify-center w-full lg:w-1/2">
          <div class="hidden lg:block">
            <img
                src="{{ Vite::asset('resources/images/landing/avanza-stock.png') }}"
                width="616"
                height="617"
                layout="intrinsic"
                loading="eager"
                placeholder="blur"
                class="rounded-4xl"
            />
          </div>
        </div>
    </heading>


    <!-- About Us -->
    <section id="about-us" class="container p-8 mx-auto xl:px-0 flex w-full flex-col mt-4 flex-wrap items-center justify-center text-center">
        <h2 class="text-sm font-bold tracking-wider text-indigo-600 uppercase">About Us</h2>
        <h3 class="max-w-2xl mt-3 text-3xl font-bold leading-snug tracking-tight text-gray-800 lg:leading-tight lg:text-4xl dark:text-white">Travel Smart, Travel Safe</h3>
        <!-- TODO: Reduce paragraph size -->
        <p class="max-w-6xl py-4 text-lg leading-normal text-gray-500 lg:text-xl xl:text-xl dark:text-gray-300">
            We understand that leaving home for university is a big step, and for parents in <span class="font-bold">Mpumalanga</span>, watching their children travel to Gauteng brings natural concerns about safety and comfort. <br><br>
            Unlike crowded shuttles or buses where you're one of many strangers, we offer something different: <span class="font-bold">a maximum of 4 students per vehicle</span>.
            This means more space for your belongings, a quieter journey to rest or study, and most importantly – a safer, more controlled environment.
        </p>
    </section>

    <!-- Features -->
    <x-benefits title="Safety Features"
        description="Your Parents can breathe easy"
        id="safety-features"
        :imageSrc="Vite::asset('resources/images/landing/avanza-stock.png')"
        :bullets="[
            [
                'icon'=>'map-pin',
                'title'=>'Real time GPS tracking',
                'description'=>'Parents can receive a live location.',
            ],
            [
                'icon'=>'user-group',
                'title'=>'Small groups only',
                'description'=>'Maximum 4 students means it doesn\'t have the crammed inpersonal vibe that a shuttle has.',
            ],
            [
                'icon'=>'user-circle',
                'title'=>'Personal service',
                'description'=>'We know every student by name, not as a number',
            ]
        ]"
    />

    <!-- Frequently Asked Questions -->
    <section id="faq" class="section-container max-w-xl flex flex-col items-center">
        <h2 class="text-sm font-bold tracking-wider text-indigo-600 uppercase">FAQ</h2>
        <h3 class="max-w-2xl mt-3 text-3xl font-bold leading-snug tracking-tight text-gray-800 lg:leading-tight lg:text-4xl dark:text-white mb-4">Frequently Asked Questions</h3>

        <x-faq-question-dropdown question="Where do you pickup and drop off?" answer="We pick up and drop off in Ermelo, Middelburg and Pretoria."/>
        <x-faq-question-dropdown question="Do you have wifi in the car?" answer="We do have uncapped wifi in the car that is available for R30 extra."/>
        <x-faq-question-dropdown question="When do you give rides?" answer="We only give rides on Fridays and Sundays, we would consider other times depending on demand. Feel free to contact us."/>
        <x-faq-question-dropdown question="Can you deliver packages?" answer="Yes, we offer package deliveries, please view our page dedicated to shipping packages."/>

    </section>


    <!-- Call to Action -->
      <div class="section-container flex flex-wrap items-center justify-between w-full mt-8 max-w-4xl gap-5 mx-auto text-white bg-indigo-600 px-7 py-7 lg:px-12 lg:py-12 lg:flex-nowrap rounded-xl">
        <div class="flex-grow text-center lg:text-left">
          <h2 class="text-2xl font-medium lg:text-3xl">
            Ready to book for a ride?
          </h2>
          <p class="mt-2 font-medium text-white text-opacity-90 lg:text-xl">
            Arrive safely this 2026
          </p>
        </div>
        <div class="flex-shrink-0 w-full text-center lg:w-auto">
          <a
            href="{{ route('book') }}"
            rel="noopener"
            class="inline-block py-3 mx-auto text-lg font-medium text-center text-indigo-600 bg-white rounded-md px-7 lg:px-10 lg:py-5 ">
            Book now
          </a>
        </div>
      </div>

    <!-- Footer -->
    <div class="relative">
            <div class="section-container grid max-w-screen-xl grid-cols-1 gap-10 pt-10 mx-auto mt-20 border-t border-gray-100 dark:border-gray-700 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <div>
                        <a href="#" class="flex items-center space-x-2 text-2xl font-medium text-indigo-500 dark:text-gray-100">
                            <span>
                                <x-icon solid name="map-pin" class="w-8 h-8" />
                            </span>
                            Student Lift
                        </a>
                    </div>

                    <div class="max-w-md mt-4 text-gray-500 dark:text-gray-400">
                    Safe Student Lift is a transport business primarily for students who want safe and comfortable
                    transport between Mupumalanga and Gauteng.
                    </div>
                </div>

                <div>
                    <div class="flex flex-wrap w-full -mt-2 -ml-3 lg:ml-0">
                        <a href="{{ route('home') }}" wire:navigate class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            Home
                        </a>
                        <a href="{{ route('home') }}#about-us" class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            About Us
                        </a>
                        <a href="{{ route('home') }}#faq" class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            FAQ
                        </a>
                        <a href="{{ route('book') }}" wire:navigate class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            Book
                        </a>
                    </div>
                </div>
                <div>
                    <div class="flex flex-wrap w-full -mt-2 -ml-3 lg:ml-0">
                        <a class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            Terms
                        </a>
                        <a class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            Privacy
                        </a>
                        <a class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                            Legal
                        </a>
                    </div>
                </div>
                <div class="">
                    <div>Follow us</div>
                    <div class="flex mt-5 space-x-5 text-gray-400 dark:text-gray-500">
                        <a
                            href="#!"
                            rel="noopener">
                            <span class="sr-only">Twitter</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width=24
                                height=24
                                viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M24 4.37a9.6 9.6 0 0 1-2.83.8 5.04 5.04 0 0 0 2.17-2.8c-.95.58-2 1-3.13 1.22A4.86 4.86 0 0 0 16.61 2a4.99 4.99 0 0 0-4.79 6.2A13.87 13.87 0 0 1 1.67 2.92 5.12 5.12 0 0 0 3.2 9.67a4.82 4.82 0 0 1-2.23-.64v.07c0 2.44 1.7 4.48 3.95 4.95a4.84 4.84 0 0 1-2.22.08c.63 2.01 2.45 3.47 4.6 3.51A9.72 9.72 0 0 1 0 19.74 13.68 13.68 0 0 0 7.55 22c9.06 0 14-7.7 14-14.37v-.65c.96-.71 1.79-1.6 2.45-2.61z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="my-10 text-sm text-center text-gray-600 dark:text-gray-400">
                Copyright © 2025 Safe Student Lift.
                <a href="https://web3templates.com/" target="_blank" rel="noopener">
            </div>
    </div>

</x-layouts>
