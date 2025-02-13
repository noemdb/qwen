<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogoutButton extends Component
{
    public function logout()
    {
        // Cerrar la sesión del usuario
        Auth::logout();

        // Invalidar la sesión actual
        session()->invalidate();

        // Regenerar el token CSRF
        session()->regenerateToken();

        // Redirigir al usuario a la página de inicio o login
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.logout-button');
    }
}