 <div>

    <div class="flex flex-col md:flex-row gap-4">
        <!-- Columna 1: Ocupa menos espacio -->
        <div class="flex-1 bg-blue-100 p-1 rounded text-gray-600 text-sm">
            @include('livewire.partials.info')
        </div>
      
        <!-- Columna 2: Ocupa más espacio -->
        <div class="flex-2 p-2">
            <div class="w-full mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    
                <div class="bg-blue-500 p-2 text-white text-center font-bold">
                    Conversación
                </div>
        
                @include('livewire.partials.messages')
        
                @include('livewire.partials.input')                
        
            </div>
        </div>
      </div>

    @section('customScript')
        @parent
        <script>
            document.addEventListener('livewire:load', function () {
                const chatBox = document.getElementById('chat-box');
        
                // Función para desplazar al final
                function scrollToBottom() {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
        
                // Desplazar al final cuando se carga la página
                scrollToBottom();
        
                // Observar cambios en el DOM (cuando Livewire actualiza el historial)
                Livewire.hook('message.processed', () => {
                    scrollToBottom();
                });
            });
        </script>
    @endsection

</div>