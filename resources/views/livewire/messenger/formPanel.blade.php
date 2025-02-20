<form wire:submit.prevent="sendMessage" class="p-4 bg-white border-t border-gray-200 w-full">
    <div class="flex items-center space-x-2">
        <textarea id="message-input" {{ (! $receiverId) ? 'disabled' : null }}
            id="messageText" wire:model.defer="messageText" wire:loading.attr="disabled"
            wire:keydown.enter="sendMessage" 
            placeholder="Escribe tu mensaje..."
            class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 disabled:bg-gray-100"
            cols="4" rows="3">
        </textarea>
        <button {{ (! $receiverId) ? 'disabled' : null }} type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 disabled:opacity-50"
            wire:loading.attr="disabled">
            Enviar
        </button>
    </div>
</form>