<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Qwen Chat App') }}</title>

    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @livewireStyles
    
    {{-- <script defer src="{{ asset('js/app.js') }}"></script> --}}
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'block' : 'hidden'" class="w-64 bg-gray-200 shadow-md">
            <div class="p-4">
                <h1 class="text-2xl font-bold text-gray-600">{{ Auth::user()->name ?? null}}</h1>
                <span class="text-sm text-gray-400">{{ Auth::user()->email ?? null}}</span>
            </div>
            <nav class="mt-4">
                {{-- <a href="#" class="border font-bold block py-2 px-4 text-gray-700 hover:bg-gray-200">{{ Auth::user()->name }}</a> --}}
                <a href="{{route('chat')}}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">QChat</a>
                <a href="{{route('prompts')}}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">Prompts</a>
                <a href="{{route('messenger')}}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">Mensajero LAN</a>
                <a href="{{route('about')}}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">Acerca de ...</a>

                <livewire:logout-button />

            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-gray-800 shadow flex items-center justify-between py-4 px-6 ">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-200 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>{{ $title ?? null }}</div>
                <h2 class="text-xl font-semibold text-gray-400">
                    <a href="{{route('welcome')}}">                        
                        QChat App CMSF v1.1
                        <i class="fa-regular fa-comment-dots p-1 m-1"></i>
                    </a>
                </h2>
            </header>

            <!-- Page Content layout -->
            <main class="flex-1 overflow-y-auto">
                <div class="w-full h-full">
                    {{ $slot }}
                </div>
            </main>

            <!-- Pie de Página -->
            <footer class="bg-gray-800 text-white text-center py-4">
                <p>&copy; {{ date('Y') }} QChat App. Contraloría Municipal de San Felipe. [@noemdb]</p>
            </footer>
        </div>
    </div>


    <script src="{{ mix('js/app.js') }}"></script>

    

    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

    

    {{-- <script defer src="{{ asset('vendor/alpine/cdn.min.js') }}"></script> --}}
    
    {{-- <script defer src="{{ asset('js/app.js') }}"></script> --}}
    
    @livewireScripts

    <!-- customScript -->
    @yield('customScript')

    <!-- websockets -->
    @yield('websockets')

</body>

</html>

