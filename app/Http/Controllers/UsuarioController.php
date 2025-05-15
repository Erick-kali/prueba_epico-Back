<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Importar la clase Hash

class UsuarioController extends Controller
{
    public function index()
    {
        // Obtiene todos los usuarios
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuario',
            'cedula' => 'required|string|max:10|unique:usuario', // Cedula como VARCHAR
            'contrasena' => 'required|string|min:8', // Contraseña
            'id_rol' => 'required|integer', // Relación con la tabla Rol
            'status' => 'nullable|in:activo,bloqueado', // Valores permitidos para status
            'bloqueado_hasta' => 'nullable|date', // Fecha opcional
        ]);

        // Hashear la contraseña antes de guardarla
        $validated['contrasena'] = Hash::make($validated['contrasena']);

        // Crear un nuevo usuario con los datos validados
        $usuario = Usuario::create($validated);

        // Retorna el usuario creado
        return response()->json($usuario, 201);
    }

    public function update(Request $request, $id)
    {
        // Buscar el usuario por su ID
        $usuario = Usuario::findOrFail($id);

        // Validar los datos de entrada
        $validated = $request->validate([
            'nombres' => 'sometimes|required|string|max:100',
            'apellidos' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|max:100',
            'cedula' => 'sometimes|required|string|max:10', // Cedula como VARCHAR
            'contrasena' => 'nullable|string|min:8', // Contraseña opcional
            'id_rol' => 'sometimes|required|integer',
            'status' => 'nullable|in:activo,bloqueado', // Actualización del estado
            'bloqueado_hasta' => 'nullable|date', // Fecha opcional
        ]);

        // Si se envió una nueva contraseña, hashearla antes de guardarla
        if (!empty($validated['contrasena'])) {
            $validated['contrasena'] = Hash::make($validated['contrasena']);
        } else {
            unset($validated['contrasena']); // Eliminar el campo para no sobrescribirlo con null
        }

        // Actualizar el usuario con los datos validados
        $usuario->update($validated);

        // Retorna el usuario actualizado
        return response()->json($usuario);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete(); // Eliminar usuario

        // Enviar una respuesta con un mensaje
        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ], 200); // Código de estado 200 (OK)
    }
}
