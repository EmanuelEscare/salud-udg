<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SE') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="font-sans bodys antialiased">
    <div class="loader">
        <div class="mx-auto my-auto">

            <div class="text-center">
                <img class="logo-loader" src="{{ asset('paz-udg.png') }}" alt="">
            </div>
            <br>
            <h1 class="text-center">
                <i class="fa-solid fa-spinner fa-spinner fa-spin-pulse loader-text"></i>
            </h1>

        </div>
    </div>

    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

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
