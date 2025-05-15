<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Obtener todos los roles
    public function index()
    {
        $roles = Rol::all();
        return response()->json($roles);
    }

    // Obtener un rol por ID
    public function show($id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }
        return response()->json($rol);
    }

    // Agregar un nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:100|unique:rol,nombre_rol',
        ]);

        $rol = Rol::create([
            'nombre_rol' => $request->nombre_rol
        ]);

        return response()->json(['message' => 'Rol creado exitosamente', 'rol' => $rol], 201);
    }

    // Actualizar un rol existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:100|unique:rol,nombre_rol,' . $id . ',id_rol',
        ]);

        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $rol->update([
            'nombre_rol' => $request->nombre_rol
        ]);

        return response()->json(['message' => 'Rol actualizado exitosamente', 'rol' => $rol]);
    }

    // Eliminar un rol
    public function destroy($id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $rol->delete();
        return response()->json(['message' => 'Rol eliminado exitosamente']);
    }
}
