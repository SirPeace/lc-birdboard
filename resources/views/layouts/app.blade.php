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
    <body class="font-sans antialiased {{ auth()->user()?->dark_theme ? 'theme-dark' : 'theme-light' }}">
        <div class="flex flex-col min-h-screen bg-body text-default">
            @include('layouts.navigation')

            <div class="flex-1 flex justify-between min-h-full relative">
                <!-- Page Content -->
                <main class="pt-8 pb-4 flex-1 container mx-auto @if (isset($sidebar)) pr-80 @endif">
                    {{ $slot }}
                </main>

                @if (isset($sidebar))
                    <!-- Sidebar -->
                    <aside class="absolute right-0 bg-sidebar w-80 h-full top-0 overflow-y-auto p-4">
                        {{ $sidebar }}
                    </aside>
                @endif
            </div>
        </div>
    </body>
</html>
