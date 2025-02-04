@extends('layouts.app')

@section('main')

    <div class="text-center">
        
        <h1 class="text-2xl font-bold text-gray-800 mb-1 text-center">Bienvenido a QChat App</h1>

        <div class="flex">

            <div class="flex-none w-1/4">

                @include('livewire.partials.info')

            </div>

            <div class="grow">

                <livewire:chat-component />

                <div class="pt-2 border-top">
                    @include('livewire.partials.prompts')
                </div>                

            </div>
            
        </div>

    </div>

@endsection