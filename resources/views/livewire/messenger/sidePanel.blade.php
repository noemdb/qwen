<div class="p-2 flex-shrink-0">
    <h2 class="text-md font-bold text-gray-800 mb-1">Destinatarios</h2>
</div>
<ul class="flex-1 px-2 py-1 space-y-2 overflow-y-auto">

    @foreach ($recipients as $id => $name)
    <li wire:click="selectRecipient({{ $id }})"
        class="p-1 text-left border rounded-lg cursor-pointer hover:bg-gray-100 {{ $receiverId == $id ? 'bg-blue-200' : '' }}"><div class="hide bg-blue-200"></div>

        <div class="flex items-center space-x-2">
            <div class="w-5 h-5 bg-gray-300 rounded-full {{ $receiverId == $id ? 'bg-blue-400' : '' }}"></div><div class="hide bg-blue-400"></div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">{{ $name }}</p>
                <p class="text-xs text-gray-500">
                    @if (!empty($lastMessages[$id]))
                    {{$lastMessages[$id]['body']}} <small class="block">{{$lastMessages[$id]['formatted_created_at']}}</small>
                    @else
                    Sin mensajes...
                    @endif
                </p>
            </div>
        </div>
    </li>
    @endforeach

</ul>