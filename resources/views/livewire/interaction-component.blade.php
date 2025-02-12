<div class="p-4 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Lista de Interacciones</h2>

    <!-- Campo de Búsqueda -->
    <div class="mb-4 relative">
        <input 
            type="text" 
            wire:model="search" 
            placeholder="Buscar interacciones..." 
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <!-- Indicador de Carga -->
        <div wire:loading class="absolute right-3 top-1/2 transform -translate-y-1/2">
            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Mensaje de Éxito -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tabla de Interacciones -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('prompt')">
                        Prompt
                        @if ($sortBy === 'prompt')
                            <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('response')">
                        Respuesta
                        @if ($sortBy === 'response')
                            <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                        Fecha
                        @if ($sortBy === 'created_at')
                            <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($interactions as $interaction)
                    <tr>
                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-900">
                            {{ Str::limit($interaction->prompt, 50) }}
                        </td>
                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-900">
                            {!! Str::limit($interaction->response, 50) !!}
                        </td>
                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-500">
                            {{ $interaction->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-500">
                            <!-- Botón para abrir el modal -->
                            <button 
                                wire:click="openModal({{ $interaction->id }})" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300"
                            >
                                {{-- Ver Detalles --}}
                                <i class="fa fa-info"></i>
                                
                            </button>

                            {{-- <button 
                                wire:click="confirmDeletion({{ $interaction->id }})" 
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300"
                            >
                                <i class="fa fa-trash"></i>
                            </button> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-2 py-1 text-center text-sm text-gray-500">
                            No hay interacciones registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $interactions->links() }}
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo Oscuro -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Contenido del Modal -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900">Detalles de la Interacción</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prompt</label>
                                <p class="mt-1 text-sm text-gray-500">{{ $selectedInteraction->prompt }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Respuesta</label>
                                <p class="mt-1 text-sm text-gray-500">{!! $selectedInteraction->response !!}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha</label>
                                <p class="mt-1 text-sm text-gray-500">{{ $selectedInteraction->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <!-- Botón para cerrar el modal -->
                        <button 
                            wire:click="closeModal" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Confirmación de Eliminación -->
    @if ($confirmingDeletion)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo Oscuro -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Contenido del Modal -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900">Confirmar Eliminación</h3>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que deseas eliminar esta interacción? Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <!-- Botón para confirmar la eliminación -->
                        <button 
                            wire:click="deleteInteraction" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Eliminar
                        </button>
                        <!-- Botón para cancelar -->
                        <button 
                            wire:click="$set('confirmingDeletion', false)" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>