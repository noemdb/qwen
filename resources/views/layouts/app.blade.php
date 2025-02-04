<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Qwen Chat App') }}</title>

    <!-- Tailwind CSS -->
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Alpine.js (opcional) -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <script defer src="{{ asset('vendor/alpine/cdn.min.js') }}"></script>
    {{-- <script defer src="{{ asset('vendor/alpine/persist.min.js') }}"></script> --}}

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">
    
    <div class="min-h-screen flex flex-col">
        <!-- Encabezado -->
        <header class="bg-gray-800 text-white shadow-md">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <h1 class="text-xl font-bold">
                    <a href="{{ route('welcome') }}" class="">QChat App. CMSF</a>                    

                </h1>
                <nav>
                    <a href="{{ route('chat') }}" class="text-white hover:text-blue-200 transition duration-300">Chat</a>
                </nav>
            </div>
        </header>

        <!-- Contenido Principal -->
        <main class="flex-grow w-full">
            @yield('main') <!-- Aquí se inyectará el contenido de las vistas secundarias -->
        </main>

        <!-- Pie de Página -->
        <footer class="bg-gray-800 text-white text-center py-4">
            <p>&copy; {{ date('Y') }} QChat App. Contraloría Municipal de San Felipe. [@noemdb]</p>
        </footer>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    @yield('customScript')

    <!-- Scripts Personalizados (opcional) -->
    <script>
        // Código JavaScript personalizado, si es necesario
    </script>
</body>
</html>