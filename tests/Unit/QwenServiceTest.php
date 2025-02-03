<?php

namespace Tests\Unit;

use App\Services\QwenService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class QwenServiceTest extends TestCase
{
    public function test_can_send_message_to_qwen_api()
    {
        // Mockear la respuesta de la API
        Http::fake([
            'http://mock-api-url.com' => Http::response(['response' => 'Respuesta simulada'], 200),
        ]);

        $qwenService = new QwenService();
        $response = $qwenService->sendMessage([['role' => 'user', 'content' => 'Hola']]); dd($response);

        // Verificar que la respuesta sea correcta
        $this->assertEquals('Respuesta simulada', $response);
    }

    public function test_throws_exception_on_api_error()
    {
        // Simular un error en la API
        Http::fake([
            'http://mock-api-url.com' => Http::response('Error', 500),
        ]);

        $qwenService = new QwenService();

        // Verificar que se lance una excepción
        $this->expectException(\Exception::class);
        $qwenService->sendMessage([['role' => 'user', 'content' => 'Hola']]);
    }
}