<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculosController extends Controller
{
    public function GetVehiculos(Request $request){
        $vehiculos = Vehiculo::leftJoin('camioneta', 'camioneta.id', '=', 'vehiculo.id')
        ->leftJoin('camion', 'camion.id', '=', 'vehiculo.id')
        ->select('camion.id as camion', 'camioneta.id as camioneta', 'vehiculo.*')
        ->get();
        return $vehiculos;
    }
    public function GetCamiones(Request $request){
        $vehiculos = Vehiculo::join('camion', 'camion.id', '=', 'vehiculo.id')->get();
        return $vehiculos;
    }
    public function GetCamionetas(Request $request){
        $vehiculos = Vehiculo::join('camioneta', 'camioneta.id', '=', 'vehiculo.id')->get();
        return $vehiculos;
    }
}
