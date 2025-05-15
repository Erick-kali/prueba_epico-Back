<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Obtener todos los productos
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria' => 'required|string|max:100',
            'proveedor' => 'required|string|max:100',
            'estado' => 'in:disponible,agotado',
            'fecha_creacion' => 'nullable|date' // opcional
        ]);

        $producto = Producto::create($validated);
        return response()->json($producto, 201);
    }

    // Mostrar un producto por su ID
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto, 200);
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'nombre_producto' => 'sometimes|required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'categoria' => 'sometimes|required|string|max:100',
            'proveedor' => 'sometimes|required|string|max:100',
            'estado' => 'in:disponible,agotado',
            'fecha_creacion' => 'nullable|date'
        ]);

        $producto->update($validated);
        return response()->json($producto, 200);
    }

    // Eliminar un producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(null, 204);
    }
}
