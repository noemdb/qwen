<div class="p-4 border-t border-green-300">

    <form wire:submit.prevent="sendMessage" class="w-full">
    
        @if ($status)
            <!-- Formulario de Mensajes -->
            
                <div id="controls" class="w-full flex items-center space-x-2">
                    <!-- Campo de Entrada -->
                    <textarea 
                        id="dynamic-textarea"
                        wire:model.defer="newMessage" 
                        wire:loading.attr="disabled" 
                        wire:keydown.enter="sendMessage"
                        placeholder="Escribe tu mensaje..." 
                        class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 disabled:bg-gray-100"
                        cols="4"
                        rows="3">
                    </textarea>

                    <label class="cursor-pointer px-2 py-2 rounded-lg hover:bg-gray-600 transition duration-300">
                        <i class="fas fa-file-pdf"></i>
                        {{-- <i class="fas fa-home text-blue-500"></i> --}}
                        {{-- <x-markdown-editor name="about" /> --}}
                        <input 
                            type="file" 
                            wire:model.defer="pdfFile" 
                            accept=".pdf" 
                            class="hidden"
                            id="pdfFile"
                            onchange="validateFile()"
                            {{-- @change="validateFile($event)" --}}
                        />
                    </label>

                    <!-- Botón de Enviar -->
                    <button 
                        type="submit" 
                        wire:loading.class="opacity-50 cursor-not-allowed" 
                        wire:loading.attr="disabled"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 disabled:bg-gray-400"
                    >
                        <span wire:loading.remove>Enviar</span>
                        <span wire:loading>Enviando...</span>
                    </button>

                    <!-- Contador de Mensajes -->
                    <div class="text-sm text-gray-600">
                        {{$request}}/{{$limit}}
                    </div>
                </div>
            
        @else
            <!-- Mensaje de Límite Alcanzado -->
            <div class="text-center text-red-600 font-semibold">
                <p class="text-sm">Alcanzaste los {{$limit}} mensajes disponibles para esta conversación.</p>
                <p class="mt-2">
                    <button 
                        onclick="location.reload()" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300"
                    >
                        Recargar página para iniciar un nuevo chat
                    </button>
                </p>
            </div>
        @endif

        @if ($pdfFile)
            <div class="mt-2 text-sm text-gray-600">
                Archivo cargado: {{ $pdfFile->getClientOriginalName() }}
                @error('pdfFile')<div class="text-red text-sm">{{ $message }}</div> @enderror
            </div>
        @endif

    </form>

    @section('customScript')
    @parent

    <script>
        function validateFile() {
            const input = document.getElementById('pdfFile');
            const file = input.files[0];

            if (file && file.size > 2 * 1024 * 1024) { // 10 MB
                alert('El archivo es demasiado grande. Máximo permitido: 2 MB');
                input.value = ''; // Limpia el archivo seleccionado
            }
        }
    </script>

    <script>
        // Función para ajustar dinámicamente el tamaño del textarea
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('dynamic-textarea');

            if (textarea) {
                textarea.addEventListener('input', function () {
                    // Restablecer la altura para calcular correctamente
                    this.style.height = 'auto';

                    // Establecer la nueva altura basada en el contenido
                    this.style.height = this.scrollHeight + 'px';
                });

                // Inicializar el tamaño al cargar la página
                textarea.style.height = textarea.scrollHeight + 'px';
            }
        });
    </script>

    @endsection

</div>