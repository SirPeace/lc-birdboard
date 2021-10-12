<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex flex-col min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div class="flex-1 container mx-auto flex justify-between min-h-full">
                <!-- Page Content -->
                <main
                    class="pt-8 pb-4 flex-1"
                    @if (Route::is('projects.show') || Route::is('projects.index')) style="margin-right: 20rem" @endif
                >
                    {{ $slot }}
                </main>

                @if ($sidebar)
                    <!-- Sidebar -->
                    <aside class="fixed right-0 bg-gray-50 w-80 h-full p-6 overflow-y-auto -mt-16 pt-24">
                        {{ $sidebar }}
                    </aside>
                @endif
            </div>
        </div>
    </body>
</html>
