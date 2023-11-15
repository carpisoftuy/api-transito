<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CargaBulto;
use App\Models\CargaBultoFin;
use Illuminate\Support\Facades\DB;

class BultosCargadosController extends Controller
{
    public function GetBultosCargados(Request $request){
        return CargaBulto::join('vehiculo', 'vehiculo.id', '=', 'id_vehiculo')
        ->whereNotIn('carga_bulto.id',
                DB::table('carga_bulto_fin')
                ->select('id')
            )
        ->get();
    }

    public function DescargarBulto(Request $request){

    $bultoDescargado = new CargaBultoFin();
    $bultoDescargado->id = $request->id;
    $bultoDescargado->fecha_fin = now();
    $bultoDescargado->save();

    }
    public function GetBultosDescargados(Request $request){
        return CargaBultoFin::all();
    }

}
