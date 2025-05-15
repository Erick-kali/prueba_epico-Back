<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Importar Carbon para manejo de fechas y tiempos

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        // Buscar al usuario en la base de datos por su email
        $usuario = Usuario::where('email', $request->email)->first();

        // Si el usuario no existe
        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        // Verificar si el usuario está bloqueado
        if ($usuario->status === 'bloqueado') {
            $ahora = Carbon::now();
            
            // Si la fecha de desbloqueo es futura
            if ($usuario->bloqueado_hasta && $ahora->lessThan($usuario->bloqueado_hasta)) {
                // Calcular el tiempo restante en minutos
                $tiempo_restante = $ahora->diffInMinutes($usuario->bloqueado_hasta);
                
                return response()->json([
                    'message' => "El usuario está bloqueado. Intente nuevamente en $tiempo_restante minutos.",
                    'tiempo_restante' => $tiempo_restante, // Enviar solo los minutos restantes
                ], 403);
            } else {
                // Desbloquear automáticamente si ha pasado el tiempo de bloqueo
                $usuario->status = 'activo';
                $usuario->numero_intento = 0;
                $usuario->bloqueado_hasta = null;
                $usuario->save();
            }
        }

        // Verificar si la contraseña ingresada es correcta
        if (Hash::check($request->contrasena, $usuario->contrasena)) {
            // Restablecer intentos fallidos al iniciar sesión correctamente
            $usuario->numero_intento = 0;
            $usuario->save();

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'usuario' => $usuario,
            ]);
        } else {
            // Incrementar el número de intentos fallidos
            $usuario->numero_intento += 1;

            // Bloquear usuario si excede los 3 intentos fallidos
            if ($usuario->numero_intento >= 3) {
                $usuario->status = 'bloqueado';
                $usuario->bloqueado_hasta = Carbon::now()->addMinutes(15); // Bloqueo por 15 minutos
            }

            $usuario->save();

            return response()->json([
                'message' => $usuario->status === 'bloqueado'
                    ? 'El usuario ha sido bloqueado por múltiples intentos fallidos, debe esperar 15 minutos para volver a intentar.'
                    : 'Credenciales incorrectas. Intento ' . $usuario->numero_intento . ' de 3.',
            ], 422);
        }
    }
}
