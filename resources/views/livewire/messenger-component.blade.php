<div class="flex flex-col h-full w-full">
    
    <!-- Contenedor Principal -->
    <div class="flex flex-1 w-full overflow-hidden">

        <!-- Panel Lateral: Lista de Destinatarios -->
        <aside class="w-80 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col overflow-y-auto">
            @include('livewire.messenger.sidePanel')            
        </aside>

        <!-- Panel Principal: Chat -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">

            @include('livewire.messenger.chatPanel')
            
            <!-- Formulario de Envío -->
            @include('livewire.messenger.formPanel')            
            

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

    @include('livewire.messenger.customScript') 
      
    @include('livewire.messenger.websockets')   

</div>