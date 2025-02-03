<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChatViewTest extends TestCase
{
    public function test_chat_view_loads_correctly()
    {
        $response = $this->get('/chat');

        // Verificar que la página cargue correctamente
        $response->assertStatus(200)
                 ->assertSee('Escribe tu mensaje...');
    }

    public function test_messages_are_displayed_in_chat()
    {
        // Simular mensajes en la sesión
        session(['chat_history' => [
            ['user' => 'user', 'text' => 'Hola'],
            ['user' => 'qwen', 'text' => 'Respuesta simulada'],
        ]]);

        $response = $this->get('/chat');

        // Verificar que los mensajes se muestren en la vista
        $response->assertSeeInOrder(['Hola', 'Respuesta simulada']);
    }
}