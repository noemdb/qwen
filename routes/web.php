<?php

// use App\Http\Livewire\ChatComponent;

use App\Models\app\Interaction;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test-event', function () {
    $message = \App\Models\Message::create([
        'body' => 'Mensaje de prueba',
        'sender_id' => 1,
        'receiver_id' => 2,
    ]);

    broadcast(new \App\Events\MessageSent(1, $message));

    return 'Evento emitido';
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/list', function () {
        return view('list');
    })->name('list');

    Route::get('/prompts', function () {
        return view('partials.prompts');
    })->name('prompts');
    
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');

    Route::get('/messenger', function () {
        return view('messenger');
    })->name('messenger');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/about', function () {
        return view('partials.about');
    })->name('about');

    
    
    
    
    // Route::get('/chat', function () {
    //     return view('chat');
    // })->name('chat');
    
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    
    
    
    
    
    // Route::get('/db', function () {
    //     $interaction = 
    //         Interaction::create([
    //             'user_id' => null,
    //             'prompt' => "promptTest",
    //             'response' => 'responseTest',
    //         ]); dd('test: ',$interaction);
    // })->name('db');

});




