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
            'react' => 'Prueba',
            '' => 'Cultura de la Paz',
        ];
        $route = Route::currentRouteName();

    @endphp
    <title>Cultura de Paz | {{ $routes[$route] }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="icon" href="{{ asset('paz-udg.png') }}" type="image/png">
    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="font-sans bodys antialiased">
    <div class="min-h-screen bg-gray-100 pb-5">

        <!-- Page Content -->
        <div class="py-3 px-5 bg-white shadow-lg">
            <img class="lg:w-2/12 md:w-6/12 sm:w-full m-auto" src="{{ asset('index/Logo-cucea-colores-icono.png') }}"
                alt="">
        </div>
        <div class="m-5">
            @section('content')
            @show
        </div>

    </div>
    @livewireScripts
</body>

</html>
