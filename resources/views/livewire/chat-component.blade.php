 <div>

    <div class="w-full h-full flex flex-col bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-blue-500 p-2 text-white text-center font-bold">
            Conversación
        </div>

        <div class="flex-grow overflow-y-auto">
            @include('livewire.partials.messages')
        </div>

        <div class="mt-auto">
            @include('livewire.partials.input')
        </div>
    </div>

    {{-- <div class="flex flex-col md:flex-row gap-4 h-full">
        <!-- Columna 1: Ocupa menos espacio -->
        <div class="flex-none md:w-1/3 bg-blue-100 p-1 rounded text-gray-600 text-sm">
            @include('livewire.partials.info')
        </div>
      
        <!-- Columna 2: Ocupa más espacio y todo el alto disponible -->
        <div class="flex-grow flex flex-col h-full">
            <div class="w-full h-full flex flex-col bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-blue-500 p-2 text-white text-center font-bold">
                    Conversación
                </div>
        
                <div class="flex-grow overflow-y-auto">
                    @include('livewire.partials.messages')
                </div>
        
                <div class="mt-auto">
                    @include('livewire.partials.input')
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div>@include('livewire.partials.prompts')</div>        
    </div>           --}}

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