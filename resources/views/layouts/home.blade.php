<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @livewireStyles

</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        {{-- @include('layouts.partials.navbar') --}}
        <div class="flex flex-1 overflow-hidden">
            @include('layouts.partials.navbar')
        </div>
    </div>

    @yield('main')

    @livewireScripts

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>