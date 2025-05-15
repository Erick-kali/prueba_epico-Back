<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HistorialMedicoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Evitar error 405 si alguien hace POST a la raíz
Route::post('/', function () {
    return response()->json([
        'message' => 'Ruta raíz POST no soportada. Usa /login para autenticación u otras rutas definidas.'
    ], 405);
});

//rutas para usuarios optimizado
Route::apiResource('usuarios', UsuarioController::class);

// Rutas para Rol
Route::apiResource('roles', RolController::class);

// Ruta para el inicio de sesión
Route::post('/login', [AuthController::class, 'login']);

//rutas para productos rest
Route::apiResource('productos', ProductoController::class);


