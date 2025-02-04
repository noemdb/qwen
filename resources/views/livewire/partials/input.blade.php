<div class="p-4 border-t border-green-300">

    <form wire:submit.prevent="sendMessage" class="w-full">
    
        @if ($status)
            <!-- Formulario de Mensajes -->
            
                <div id="controls" class="w-full flex items-center space-x-2">
                    <!-- Campo de Entrada -->
                    <textarea 
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

        <!-- Notificación -->
        {{-- <div 
        x-show="showNotification" 
        x-transition 
        class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
        role="alert"
        >
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline">El archivo es demasiado grande. Máximo permitido: 2 MB.</span>
            <button 
                @click="showNotification = false" 
                class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-500 focus:outline-none">
                &times;
            </button>
        </div> --}}

    </form>

    @section('customScript')
    @parent

    {{-- <script>
        function fileUploadHandler() {
          return {
            showNotification: false,
            validateFile(event) {
              const file = event.target.files[0];
              if (file && file.size > 2 * 1024 * 1024) { // 10 MB
                this.showNotification = true;
                event.target.value = ''; // Limpia el archivo seleccionado
              } else {
                this.showNotification = false; // Oculta la notificación si todo está bien
              }
            }
          };
        }
    </script> --}}

    @endsection

</div>