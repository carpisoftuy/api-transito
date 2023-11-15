<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaquetesCargadosController;
use App\Http\Controllers\BultosCargadosController;
use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\BultosController;
use App\Http\Controllers\VehiculosController;
use App\Http\Controllers\PaquetesController;

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

Route::prefix('v1')->group(function(){
    Route::get('paquetes/cargados/{id}',[PaquetesCargadosController::class, 'MostrarPaquetesCargados']);
    Route::post('paquetes/entregar/', [PaquetesCargadosController::class, 'EntregarPaquete']);
    Route::get('paquetes/entregados/', [PaquetesCargadosController::class, 'MostrarPaquetesEntregados']);
    Route::get('paquetes/paraEntregar/', [PaquetesCargadosController::class, 'MostrarPaquetesParaEntregar']);
    Route::get('paquetes/paraEntregar/{id}', [PaquetesCargadosController::class, 'MostrarPaquetesParaEntregarDeUnChofer']);
    Route::get('paquetes/paraEntregar/detalle/{id}', [PaquetesCargadosController::class, 'DetallePaquete']);

    Route::get('bultos/cargados/',[BultosCargadosController::class, 'GetBultosCargados']);
    Route::post('bultos/descargar/',[BultosCargadosController::class, 'DescargarBulto']);
    Route::get('bultos/descargados/',[BultosCargadosController::class, 'GetBultosDescargados']);

    Route::get('almacenes/',[AlmacenesController::class, 'GetAlmacenes']);


});

Route::prefix('v2')->group(function(){
    Route::get('vehiculos', [VehiculosController::class, 'GetVehiculos']);
    Route::get('camiones', [VehiculosController::class, 'GetCamiones']);
    Route::get('camionetas', [VehiculosController::class, 'GetCamionetas']);

    Route::get('almacenes',[AlmacenesController::class, 'GetAlmacenes']);

    Route::get('paquetes/camionetas/{id}', [PaquetesController::class, 'GetPaquetesCargadosEnCamioneta']);
    Route::post('paquetes/entregar', [PaquetesController::class, 'EntregarPaquete']);
    Route::post('paquetes/descargar', [PaquetesController::class, 'DescargarPaquete']);

    Route::get('bultos/camiones/{id}', [BultosController::class, 'GetBultosCargadosEnCamion']);
    Route::post('bultos/descargar', [BultosController::class, 'DescargarBulto']);
});
