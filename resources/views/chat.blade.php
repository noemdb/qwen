<x-dashboard-layout>

    <x-slot name="title">
        <div class="text-3xl font-bold text-white">QChat Appp</div>
        <span class="text-gray-200 m-0 p-0 text-sm">Bienvenido</span>
    </x-slot>


    <div class="text-center">
        {{-- <h4 class="text-3xl font-bold text-gray-800 mb-2">QChat App</h4> --}}
        {{-- <p class="text-gray-600 mb-6">Bienvenido a QChat App.</p> --}}
        
        <div class="p-1">
            <livewire:chat-component />
        </div> 
        
        {{-- <div class="pt-2 border-top">
            @include('livewire.partials.prompts')
        </div> --}}

    </div>

</x-dashboard-layout>