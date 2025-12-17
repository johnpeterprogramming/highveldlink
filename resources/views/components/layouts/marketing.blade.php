
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>

    <body class="flex flex-col min-h-screen">
        @include('partials.navbar')

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50">
            {{ $slot }}
        </main>

        <!-- Global notifications -->
        @persist('notifications')
        <x-notifications />
        @endpersist

        @livewireScripts
        <script>
            // Logic to show notification from outside livewire components(like middleware)
            const notification = @json(session()->pull('wireui.notification'));
            if (notification)
                window.onload = () => { $wireui.notify(notification); }
        </script>
    </body>
</html>
