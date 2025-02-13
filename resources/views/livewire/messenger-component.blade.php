<div class="flex flex-col h-full w-full">
    <!-- Contenedor Principal -->
    <div class="flex flex-1 w-full overflow-hidden">
        <!-- Panel Lateral: Lista de Destinatarios -->
        <aside class="w-80 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col overflow-y-auto">
            <div class="p-2 flex-shrink-0">
                <h2 class="text-md font-bold text-gray-800 mb-1">Destinatarios</h2>
            </div>
            <ul class="flex-1 px-2 py-1 space-y-2 overflow-y-auto">
                @foreach ($recipients as $id => $name)
                <li wire:click="selectRecipient({{ $id }})"
                    class="p-1 text-left border rounded-lg cursor-pointer hover:bg-gray-100 {{ $selectedRecipient == $id ? 'bg-blue-100' : '' }}">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
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
        </aside>

        <!-- Panel Principal: Chat -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <div id="message-box" class="flex-1 overflow-y-auto p-4 space-y-4 w-full"
                x-data="{ showOldMessages: false }">
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
                <div class="space-y-4">
                    @forelse ($todayMessages as $message)
                    <div class="{{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                        <div
                            class="inline-block p-4 max-w-xs rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }}">
                            <p class="text-sm text-gray-700">{{ $message->body }}</p>
                            <small class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }} {{
                                $message->created_at }} - {{ date('d/m H:i') }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500">No hay mensajes de hoy disponibles.</p>
                    @endforelse
                </div>
            </div>

            <!-- Formulario de Envío -->
            <form wire:submit.prevent="sendMessage" class="p-4 bg-white border-t border-gray-200 w-full">
                <div class="flex items-center space-x-2">
                    {{-- <input type="text" wire:model.defer="messageText" placeholder="Escribe un mensaje..."
                        class="flex-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    --}}

                    <textarea {{ (! $selectedRecipient) ? 'disabled' : null }} id="messageText" wire:model.defer="messageText" wire:loading.attr="disabled"
                        wire:keydown.enter="sendMessage" placeholder="Escribe tu mensaje..."
                        class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 disabled:bg-gray-100"
                        cols="4" rows="3">
                    </textarea>
                    <button {{ (! $selectedRecipient) ? 'disabled' : null }} type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Enviar</span>
                        <span wire:loading>Enviando...</span>
                    </button>

                </div>


            </form>

            <!-- Listado de Emojis (Emergente) -->
            {{-- <div x-data="{ showEmojis: true }" x-show="showEmojis" @click.away="showEmojis = false"
                class="bg-white border border-gray-200 rounded-lg shadow-lg p-4 space-y-2 w-48 z-10">
                <div class="grid grid-cols-4 gap-2">
                    <!-- Lista de Emojis -->
                    <button type="button"
                        @click="document.getElementById('messageText').value += '😊'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        😊
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '😂'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        😂
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '❤️'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        ❤️
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '👍'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        👍
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '🎉'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        🎉
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '🔥'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        🔥
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '🤔'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        🤔
                    </button>
                    <button type="button"
                        @click="document.getElementById('messageText').value += '😎'; showEmojis = false"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300">
                        😎
                    </button>
                </div>
            </div> --}}

            @if ($errors->any())
            <div {{ $attributes ?? null }}>
                <div class="font-medium text-red-600">
                    {{ __('¡Ups! Algo ha salido mal.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    @section('customScript')
    @parent
    <script>
        document.addEventListener('livewire:load', function () {
                console.log('livewire:load');
                const chatBox = document.getElementById('message-box');

                // Función para desplazar al final
                function scrollToBottom() {
                    if (chatBox) {
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                }

                // Desplazar al final cuando se carga la página
                scrollToBottom();

                // Observar cambios en el DOM (cuando Livewire actualiza el historial)
                Livewire.hook('message.processed', () => {
                    scrollToBottom();
                });
            });

            window.Echo.join(`chat.${selectedRecipient}`)
            .listen('MessageSent', (e) => {
                // Agregar el nuevo mensaje a la lista
                this.messages.push(e.message);
            });
    </script>
    @endsection

</div>