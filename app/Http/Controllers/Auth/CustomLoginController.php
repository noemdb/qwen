<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    /**
     * Mostrar el formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Validar y autenticar al usuario.
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/chat'); // Redirigir al dashboard o chat
        }

        // Si falla la autenticación, mostrar un mensaje de error
        return back()->withErrors([
            'username' => 'Las credenciales no coinciden.',
        ]);
    }

    // /**
    //  * Cerrar sesión.
    //  */
    // public function logout(Request $request)
    // {
    //     dd('123');
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/');
    // }

    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario
        Auth::logout();

        // Invalidar la sesión actual
        $request->session()->invalidate();

        // Regenerar el token CSRF
        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de inicio o login
        return redirect('/');
    }
}