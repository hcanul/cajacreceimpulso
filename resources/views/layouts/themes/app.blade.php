<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=roboto:400,500,600&display=swap" rel="stylesheet" />


        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
<body class="font-sans antialiased">
    <!-- Page Content -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Page Content -->
        <main class="flex-grow">
            {{-- head --}}
            @include('layouts.themes.content.navBar')

            {{-- sidebar --}}
            @include('layouts.themes.content.sideBar')

            {{-- contenido --}}
            @include('layouts.themes.content.content')

            {{-- footer --}}
            @include('layouts.themes.content.footer')

        </main>

    </div>
    <x-sweet-toast />
    @stack('modals')

    {{-- @livewireScripts --}}
    <script src="{{ asset('js/livewire.js') }}"></script>
</body>
</html>
