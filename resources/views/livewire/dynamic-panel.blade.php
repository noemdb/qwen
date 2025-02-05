<div>
    @switch($currentView)
        @case('dashboard')
            @include('livewire.partials.dashboard')
        @break

        @case('history')
            @include('livewire.partials.history')
        @break

        @case('settings')
            @include('livewire.partials.settings')
        @break

        @default
            @include('livewire.partials.dashboard')
    @endswitch
</div>