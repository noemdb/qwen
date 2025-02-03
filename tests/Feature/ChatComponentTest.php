<?php

namespace Tests\Feature;

// use App\Livewire\ChatComponent;
// use App\Services\QwenService;

use App\Http\Livewire\ChatComponent;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class ChatComponentTest extends TestCase
{
    public function test_user_can_send_message_and_receive_response()
    {
        // Mockear la respuesta de la API
        Http::fake([
            '*' => Http::response(['response' => 'Respuesta simulada'], 200),
        ]);

        Livewire::test(ChatComponent::class)
            ->set('newMessage', 'Hola')
            ->call('sendMessage')
            ->assertSee('Respuesta simulada');
    }

    public function test_user_cannot_send_empty_message()
    {
        Livewire::test(ChatComponent::class)
            ->set('newMessage', '')
            ->call('sendMessage')
            ->assertDontSee('Respuesta simulada');
    }

    public function test_chat_history_is_updated_correctly()
    {
        // Mockear la respuesta de la API
        Http::fake([
            '*' => Http::response(['response' => 'Respuesta simulada'], 200),
        ]);

        Livewire::test(ChatComponent::class)
            ->set('newMessage', 'Hola')
            ->call('sendMessage')
            ->assertSeeInOrder(['Hola', 'Respuesta simulada']);
    }
}