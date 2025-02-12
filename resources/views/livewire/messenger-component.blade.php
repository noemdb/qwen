<div class="flex h-screen bg-gray-100">
    <!-- Panel Lateral: Lista de Destinatarios -->
    <aside class="w-80 bg-white border-r border-gray-200 overflow-y-auto">
        <div class="p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Destinatarios</h2>
            <ul class="space-y-2">
                @foreach ($recipients as $id => $name)
                    <li 
                        wire:click="selectRecipient({{ $id }})" 
                        class="p-3 rounded-lg cursor-pointer hover:bg-gray-100 {{ $selectedRecipient == $id ? 'bg-blue-100' : '' }}"
                    >
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-gray-300 rounded-full"></div> <!-- Placeholder para avatar -->
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $name }}</p>
                                <p class="text-xs text-gray-500">
                                    @if (isset($lastMessages[$id]))
                                        {{ Str::limit($lastMessages[$id]->body, 20) }}
                                    @else
                                        Sin mensajes...
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <!-- Panel Principal: Chat -->
    <main class="flex-1 flex flex-col">
        <!-- Lista de Mensajes -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            @forelse ($messages as $message)
                <div class="{{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                    <div class="inline-block p-4 max-w-xs rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }}">
                        <p class="text-sm text-gray-700">{{ $message->body }}</p>
                        <small class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No hay mensajes disponibles.</p>
            @endforelse
        </div>

        <!-- Formulario de Envío -->
        <form wire:submit.prevent="sendMessage" class="p-4 bg-white border-t border-gray-200">
            <div class="flex items-center space-x-2">
                <input 
                    type="text" 
                    wire:model="messageText" 
                    placeholder="Escribe un mensaje..." 
                    class="flex-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Enviar</span>
                    <span wire:loading>Enviando...</span>
                </button>
            </div>
        </form>
    </main>
</div>