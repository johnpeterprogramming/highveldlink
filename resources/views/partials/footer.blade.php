<!-- Footer -->
<div class="relative">
    <div class="section-container grid max-w-screen-xl grid-cols-1 gap-10 pt-8 mx-auto mt-20 border-t border-gray-100 dark:border-gray-700 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div>
                <a href="#" class="flex items-center space-x-2 text-2xl font-medium text-indigo-500 dark:text-gray-100">
                    <span>
                        <x-icon solid name="map-pin" class="w-8 h-8" />
                    </span>
                    Highveld Link
                </a>
            </div>

            <div class="max-w-md mt-4 text-gray-500 dark:text-gray-400">
                Highveld Link is a transport business primarily for students or seniors who want safe and comfortable
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
                <a href="{{ route('terms-and-conditions') }}" wire:navigate class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                    Terms &amp Conditions
                </a>
                <a href="{{ route('privacy-policy') }}" wire:navigate class="w-full px-4 py-2 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700">
                    Privacy Policy
                </a>
            </div>
        </div>
        <!-- <div class=""> -->
        <!--     <div>Follow us</div> -->
        <!--     <div class="flex mt-5 space-x-5 text-gray-400 dark:text-gray-500"> -->
        <!--         <a -->
        <!--             href="#!" -->
        <!--             rel="noopener"> -->
        <!--             <span class="sr-only">Twitter</span> -->
        <!--             <svg -->
        <!--                 xmlns="http://www.w3.org/2000/svg" -->
        <!--                 width=24 -->
        <!--                 height=24 -->
        <!--                 viewBox="0 0 24 24" -->
        <!--                 fill="currentColor"> -->
        <!--                 <path d="M24 4.37a9.6 9.6 0 0 1-2.83.8 5.04 5.04 0 0 0 2.17-2.8c-.95.58-2 1-3.13 1.22A4.86 4.86 0 0 0 16.61 2a4.99 4.99 0 0 0-4.79 6.2A13.87 13.87 0 0 1 1.67 2.92 5.12 5.12 0 0 0 3.2 9.67a4.82 4.82 0 0 1-2.23-.64v.07c0 2.44 1.7 4.48 3.95 4.95a4.84 4.84 0 0 1-2.22.08c.63 2.01 2.45 3.47 4.6 3.51A9.72 9.72 0 0 1 0 19.74 13.68 13.68 0 0 0 7.55 22c9.06 0 14-7.7 14-14.37v-.65c.96-.71 1.79-1.6 2.45-2.61z" /> -->
        <!--             </svg> -->
        <!--         </a> -->
        <!--     </div> -->
        <!-- </div> -->
    </div>

    <div class="my-10 text-sm text-center text-gray-600 dark:text-gray-400">
        Copyright © 2025 Highveld Link.
        <a href="https://web3templates.com/" target="_blank" rel="noopener">
    </div>
</div>
