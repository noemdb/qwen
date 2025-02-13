<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CustomRegisterController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Manejar el registro de un nuevo usuario.
     */
    public function register(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        // Si la validación falla, redirigir con errores
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Autenticar al usuario automáticamente después del registro
        auth()->login($user);

        // Redirigir al usuario a la página deseada (por ejemplo, el chat)
        return redirect('/chat')->with('success', '¡Registro exitoso!');
    }
}