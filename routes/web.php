<?php

// use App\Http\Livewire\ChatComponent;

use App\Models\app\Interaction;
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

Route::get('/list', function () {
    // return view('welcome');
    return view('list');
})->name('list');

Route::get('/', function () {
    return view('dashboard');
})->name('welcome');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/prompts', function () {
    return view('partials.prompts');
})->name('prompts');

Route::get('/about', function () {
    return view('partials.about');
})->name('about');

Route::get('/db', function () {
    $interaction = 
        Interaction::create([
            'user_id' => null,
            'prompt' => "promptTest",
            'response' => 'responseTest',
        ]); dd('test: ',$interaction);
})->name('db');


