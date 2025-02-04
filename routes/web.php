<?php

// use App\Http\Livewire\ChatComponent;
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

Route::get('/', function () {
    // return view('welcome');
    return view('chat');
})->name('welcome');

// Route::get('/chat', function () {
//     return view('chat');
// })->name('chat');

// Route::get('/chat', ChatComponent::class)->name('chat');


Route::middleware(['web'])->group(function () {
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');
});
