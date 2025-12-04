@props([
    'title',
    'description',
    'imageSrc',
    'imgPos' => '',
    'bullets' => [],
    'id',
    'class' => ''
])

<section id="{{ $id }}" class="section-container flex flex-wrap mb-20 lg:gap-10 lg:flex-nowrap {{ $class }}">

    <!-- Image -->
    <div class="flex items-center justify-center w-full lg:w-1/2
        {{ $imgPos == 'right' ? 'lg:order-1' : '' }}">
        <img src="{{ $imageSrc }}" width="521" height="482" layout="intrinsic" placeholder="blur" />
    </div>

    <!-- Benefits -->
    <div class="flex flex-wrap items-center w-full lg:w-1/2
        {{ $imgPos === 'right' ? 'lg:justify-end' : '' }} ">

        <div class="flex flex-col w-full mt-4">
            <!-- Title -->
            <h3 class="max-w-2xl mt-3 text-3xl font-bold leading-snug tracking-tight text-gray-800 lg:leading-tight lg:text-4xl dark:text-white">
                {{ $title }}
            </h3>

            <!-- Description -->
            <p class="max-w-2xl py-4 text-lg leading-normal text-gray-500 lg:text-xl xl:text-xl dark:text-gray-300">
                {{ $description }}
            </p>
        </div>

        <!-- Bullet Points -->
        <div class="w-full my-5">
            @foreach($bullets as $bullet)
            <div class="flex items-start mt-8 space-x-3">
                <div class="flex items-center justify-center flex-shrink-0 mt-1 bg-indigo-500 rounded-md w-11 h-11 ">
                    <x-icon name="{{ $bullet['icon'] }}" class="w-7 h-7 text-indigo-50"/>
                </div>
                <div>
                    <h4 class="text-xl font-medium text-gray-800 dark:text-gray-200">
                        {{ $bullet['title'] }}
                    </h4>
                    <p class="mt-1 text-gray-500 dark:text-gray-400">
                        {{ $bullet['description'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
