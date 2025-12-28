<x-layouts.marketing>

    <!--  Landing  -->
    <heading class="container p-8 mx-auto xl:px-0 flex flex-wrap">

        <div class="flex items-center w-full lg:w-1/2">
          <div class="max-w-2xl mb-8">
            <h1 class="text-4xl font-bold leading-snug tracking-tight text-gray-800 lg:text-4xl lg:leading-tight xl:text-6xl xl:leading-tight dark:text-white">
                Highveld Link
            </h1>
                <p class="py-5 text-xl leading-normal text-gray-500 lg:text-xl xl:text-2xl dark:text-gray-300">Safe, private rides between Mpumalanga and Pretoria
                    via Hendrina, Middelburg and Witbank. We focus especially on students and seniors.</p>

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
        <p class="max-w-3xl py-4 text-lg leading-normal text-gray-500 lg:text-xl xl:text-xl dark:text-gray-300">
            We understand that leaving home for university is a big step, and for parents in <span class="font-bold">Mpumalanga</span>, watching their children travel to Gauteng brings natural concerns about safety and comfort. <br><br>
            Unlike crowded shuttles or buses where you're one of many strangers, we offer something different: <span class="font-bold">a maximum of 4 passengers per vehicle</span>. <br><br>
            This means more space for your belongings, a quieter journey to rest or study, and most importantly – a safer, more controlled environment.
        </p>
    </section>

    <!-- Features -->
    <x-benefits title="What makes us different"
        id="what-makes-us-different"
        :imageSrc="Vite::asset('resources/images/landing/avanza-stock.png')"
        :bullets="[
            [
                'icon'=>'wifi',
                'title'=>'Free Wifi',
                'description'=>'Surf the web with no additional costs.',
            ],
            [
                'icon'=>'map-pin',
                'title'=>'Real time GPS tracking',
                'description'=>'Parents can receive a live location.',
            ],
            [
                'icon'=>'arrow-long-right',
                'title'=>'Direct Dropoff',
                'description'=>'Available if your dropoff is in Hatfield, Hillcrest or Ermelo.',
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


</x-layouts>
