<div id="message-box" class="flex-1 overflow-y-auto p-4 space-y-4 w-full" x-data="{ showOldMessages: false }">
    <!-- Sección 1: Mensajes Antiguos (Ocultos por defecto) -->
    <div x-show="showOldMessages" class="space-y-4">
        @forelse ($oldMessages as $message)
        <div class="{{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
            <div
                class="inline-block p-4 max-w-xs rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }}">
                <p class="text-sm text-gray-700">{{ $message->body }}</p>
                <small class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">No hay mensajes antiguos disponibles.</p>
        @endforelse
    </div>

    <!-- Botón para Mostrar/Ocultar Mensajes Antiguos -->
    <button @click="showOldMessages = !showOldMessages"
        class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
        <span x-text="showOldMessages ? 'Ocultar mensajes antiguos' : 'Mostrar mensajes antiguos'"></span>
    </button>

    <!-- Sección 2: Mensajes de Hoy (Visibles por defecto) -->
    {{-- <div class="space-y-4" wire:poll.5s="loadMessages"> --}}
    <div class="space-y-4">
        @forelse ($todayMessages as $message)
        <div class="{{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
            <div
                class="inline-block p-4 max-w-xs rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }}">
                <p class="text-sm text-gray-700">{{ $message->body }}</p>
                <small class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                {{-- <small class="text-xs text-gray-500">{{ $message->created_at }} - {{ date('d/m H:i') }}</small>
                --}}
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">No hay mensajes de hoy disponibles.</p>
        @endforelse
    </div>

</div>