<x-dashboard-layout>

    <div class="bg-white shadow rounded-lg relative h-full" x-data="{ showList: true }">
        <!-- Botón flotante para mostrar/ocultar la lista -->
        <button @click="showList = !showList" class="fixed bottom-4 right-4 bg-gray-200 text-gray-600 p-2 rounded-full shadow-lg hover:bg-gray-300 focus:outline-none">
            <span x-text="showList ? '−' : '+'" class="text-xl font-bold"></span>
        </button>
    
        <div class="flex flex-col md:flex-row gap-4 h-full">
            <!-- Columna chat-component -->
            <div :class="showList ? 'flex-1' : 'flex-1 md:w-full'">
                <livewire:chat-component />
            </div>
    
            <!-- Columna list -->
            <div x-show="showList" class="w-full md:w-1/4 bg-gray-200 rounded-lg shadow-md h-full">
                <div class="w-full h-full">
                    <!-- Contenedor Principal -->
                    <div class="mx-1 bg-white rounded-lg shadow-md overflow-hidden h-full">
                        <!-- Encabezado -->
                        <div class="bg-green-600 text-white px-1">
                            <h1 class="text-md font-bold p-2">Ejemplos de Prompts para Auditoría de Obras Públicas</h1>        
                        </div>
    
                        <!-- Sección de Descripción con scroll -->
                        <div class="p-1 text-left px-1 text-sm h-full overflow-y-auto">
                            @include('partials.list')
                        </div>
                    </div>
                </div>
            </div>                      
        </div>        
    </div>

</x-dashboard-layout>