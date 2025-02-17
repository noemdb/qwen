<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {       

        User::create([
            'name' => 'Admin User',
            'username' => 'ndominguez',
            'email' => 'admin@example.com',
            'password' => Hash::make('ndominguez'), // Cambia la contraseña por seguridad
        ]);

        User::create([
            'name' => 'Funcionario',
            'username' => 'noemdb',
            'email' => 'noemdb@example.com',
            'password' => Hash::make('noemdb'), // Cambia la contraseña por seguridad
        ]);

        User::factory(30)->create();

    }
}
