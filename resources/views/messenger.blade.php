<x-dashboard-layout>

    <x-slot name="title">
        <div class="text-3xl font-bold text-white">Mensajero LAN</div>
        <span class="text-gray-200 m-0 p-0 text-sm">Servicio de Mensajería Interna CMSF.</span>
    </x-slot>

    <div class="text-center h-full">
        
        
        <div class="p-1 border-top h-full">
            <livewire:messenger-component />
        </div>       

    </div>

</x-dashboard-layout>