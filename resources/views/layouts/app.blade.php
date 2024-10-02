<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $routes = [
            'users' => 'Usuarios',
            'patients' => 'Pacientes',
            'config' => 'Configuración',
            'backup_instructions' => 'Instrucciones',
            'test' => 'Prueba',
            'agendarCita' => 'Agendar cita',
            '' => 'Cultura de la Paz',
        ];

        $route = Route::currentRouteName();
    @endphp

    @if (array_key_exists($route, $routes))
        <title>Cultura de Paz | {{ $routes[$route] }}</title>
    @else
        <title>Cultura de Paz</title>
    @endif

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="icon" href="{{ asset('cucei-logo.jpeg') }}" type="image/png">
    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="font-sans bodys antialiased">
    <div class="loader">
        <div class="mx-auto my-auto">

            <div class="text-center">
                <img class="logo-loader" src="{{ asset('cucei-logo-simple.png') }}" alt="">
            </div>
            <br>
            <h1 class="text-center">
                <i class="fa-solid fa-spinner fa-spinner fa-spin-pulse loader-text"></i>
            </h1>

        </div>
    </div>

    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        <div class="py-5"></div>
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @livewireScripts

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const loader = document.querySelector(".loader");

            const body = document.querySelector(".bodys");
            // body.style.overflow = 'hidden';

            setTimeout(function() {
                loader.style.opacity = "0";
                requestAnimationFrame(function() {
                    loader.classList.add("hidden");
                });
            }, 900);
            // setTimeout(function() {
            //     body.style.overflow = 'scroll';
            // }, 1200);

            loader.addEventListener("transitionend", function() {
                loader.remove();
            }, {
                once: true
            });
        });
    </script>
</body>

</html>
