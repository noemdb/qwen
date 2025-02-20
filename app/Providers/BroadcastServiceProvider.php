<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Middleware\BroadcastAuthMiddleware;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Broadcast::routes();

        // Broadcast::routes(['middleware' => ['auth:sanctum']]); // Ajusta según tu sistema de autenticación
        // Broadcast::routes(['middleware' => ['auth']]); // Ajusta según tu sistema de autenticación

        // Broadcast::routes([
        //     'middleware' => [EnsureFrontendRequestsAreStateful::class, 'broadcast.auth', 'auth:sanctum']
        // ]);

        Broadcast::routes(['middleware' => ['broadcast.auth']]);

        require base_path('routes/channels.php');
    }
}
