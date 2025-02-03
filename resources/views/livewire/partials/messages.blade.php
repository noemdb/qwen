<div class="p-4 h-96 overflow-y-auto" id="chat-box">
    <div class="space-y-4" id="main-text">
        @foreach ($messages as $index => $message)
            <div class="{{ $message['user'] === 'user' ? 'text-right' : 'text-left' }}" id="message-{{$index}}">
                <div class="{{ $message['user'] === 'user' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }} inline-block rounded-lg px-4 py-2">
                    <!-- Mostrar mensaje truncado o completo -->
                    <div>
                        {!! $message['text'] !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>