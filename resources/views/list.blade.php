<x-dashboard-layout>

    <x-slot name="title">
        <div class="text-3xl font-bold text-white">Qwen Chat App</div>
        <span class="text-gray-200 m-0 p-0 text-sm">Listado de las interacciónes registradas.</span>
    </x-slot>

    <div class="text-center">
        
        <div class="p-1">
            <livewire:interaction-component />
        </div>       

    </div>

</x-dashboard-layout>