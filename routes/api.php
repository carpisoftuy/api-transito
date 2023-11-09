<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaquetesCargadosController;
use App\Http\Controllers\BultosCargadosController;
use App\Http\Controllers\AlmacenesController;

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
