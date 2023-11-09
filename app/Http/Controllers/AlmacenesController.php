<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Ubicacion;

class AlmacenesController extends Controller
{
    public function GetAlmacenes(Request $request){
        return Almacen::join('ubicacion', 'ubicacion.id', '=', 'almacen.id_ubicacion')->get();

    }
    
}
