<?php

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Broadcast;



/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/



// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// // Broadcast::channel('private-chat.{userId}', function ($user, $userId) {
// //     // Solo permite acceso si el ID del usuario coincide con el ID del canal
// //     return (int) $user->id === (int) $userId;
// // });


// Broadcast::routes(['middleware' => ['auth:sanctum']]);
// // Broadcast::routes(['middleware' => ['auth']]);
// // Broadcast::routes(['middleware' => ['broadcast.auth']]);

// Broadcast::channel('chat.{userId}', function ($user, $userId) {
//     // Lógica de autorización para canales privados
//     return (int) $user->id === (int) $userId;
// });