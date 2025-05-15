<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class HashPasswords extends Command
{
    protected $signature = 'hash:passwords';
    protected $description = 'Hashea las contraseñas de los usuarios en la base de datos';

    public function handle()
    {
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            if (!str_starts_with($usuario->contrasena, '$2y$')) { // Verifica si ya está hasheada
                $usuario->contrasena = Hash::make($usuario->contrasena);
                $usuario->save();
            }
        }

        $this->info('Contraseñas actualizadas correctamente.');
    }
}
