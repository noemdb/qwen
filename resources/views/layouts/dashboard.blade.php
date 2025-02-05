<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Chat Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md">
            <div class="p-4">
                <h1 class="text-2xl font-bold text-gray-800">AI Chat</h1>
            </div>
            <nav class="mt-4">
                <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">Dashboard</a>
                <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">Historial</a>
                <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">Configuración</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="py-4 px-6">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yiel('main')
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>

