<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\departamentosController;
use App\Http\Controllers\empleadoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
#listar empleados
Route::middleware(['auth:api'])->group(function () {
Route::get('/empleados', [empleadoController::class, 'index']);
});
#agregar empleados
Route::middleware(['auth:api'])->group(function () {
Route::post('/agregarEmpleado', [empleadoController::class, 'store']);
});
#buscar empleado
Route::middleware(['auth:api'])->group(function () {
Route::get('/buscarEmpleado/{id}', [empleadoController::Class,'show']);
});
#eliminar empleado
Route::middleware(['auth:api'])->group(function () {
Route::delete('/eliminarEmpleado/{id}', [empleadoController::class, 'destroy']);
});
#editar empleado
Route::middleware(['auth:api'])->group(function () {
Route::patch('/editarEmpleado/{id}', [empleadoController::class, 'updatePartial']);
});
#listar departamentos
Route::middleware(['auth:api'])->group(function () {
    Route::get('/departamentos', [departamentosController::class, 'index']);
});
#buscar departamentos
Route::middleware(['auth:api'])->group(function () {
Route::get('/buscarDepa/{id}', [departamentosController::Class,'show']);
});
#crear departamentos
Route::middleware(['auth:api'])->group(function () {
    Route::post('/crearDepa', [departamentosController::class, 'store']);
});
Route::middleware(['auth:api'])->group(function () {
Route::put('/editarDepa/{id}', [departamentosController::class, 'update']);
});
#editar departamentos
Route::middleware(['auth:api'])->group(function () {
Route::patch('/editarDepa/{id}', [departamentosController::class, 'updatePartial']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');

});
