<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paquete;
use App\Models\PaqueteEntregado;
use App\Models\CargaPaquete;
use App\Models\CargaPaqueteFin;
use App\Models\AlmacenContienePaquete;

class PaquetesController extends Controller
{
    public function GetPaquetesCargadosEnCamioneta(Request $request){
        $paquetes = Paquete::join('carga_paquete', 'carga_paquete.id_paquete', '=', 'paquete.id')
        ->whereNotIn('carga_paquete.id',
            DB::table('carga_paquete_fin')
            ->select('id')
        )
        ->join('vehiculo', 'vehiculo.id', '=', 'carga_paquete.id_vehiculo')
        ->where('vehiculo.id', '=', $request->id)
        ->select('*', 'carga_paquete.id')
        ->get();

        return $paquetes;
    }

    public function EntregarPaquete(Request $request){
        $paquete = Paquete::leftJoin('paquete_para_entregar', 'paquete.id', '=', 'paquete_para_entregar.id')
        ->select('paquete_para_entregar.id as para_entregar', 'paquete.id')
        ->where('paquete.id', '=', $request->id_paquete)
        ->first();

        $paquetesEnCamioneta = CargaPaquete::where('carga_paquete.id_paquete', '=', $paquete->id)
        ->whereNotIn('carga_paquete.id',
            DB::table('carga_paquete_fin')
            ->select('id')
        )
        ->get();

        foreach($paquetesEnCamioneta as $paqueteEnCamioneta){
            $paquetesEnCamionetaFin = new CargaPaqueteFin();
            $paquetesEnCamionetaFin->id = $paqueteEnCamioneta->id;
            $paquetesEnCamionetaFin->fecha_fin = now();
            $paquetesEnCamionetaFin->save();
        }

        if($paquete->para_entregar != null){
            $paqueteEntregado = new PaqueteEntregado();
            $paqueteEntregado->id = $paquete->para_entregar;
            $paqueteEntregado->fecha_entregado = now();
            $paqueteEntregado->save();
        }

        return "entregado";
    }

    public function DescargarPaquete(Request $request){
        $paquetesEnCamioneta = CargaPaquete::where('carga_paquete.id_paquete', '=', $request->id_paquete)
        ->whereNotIn('carga_paquete.id',
            DB::table('carga_paquete_fin')
            ->select('id')
        )
        ->get();

        foreach($paquetesEnCamioneta as $paqueteEnCamioneta){
            $paquetesEnCamionetaFin = new CargaPaqueteFin();
            $paquetesEnCamionetaFin->id = $paqueteEnCamioneta->id;
            $paquetesEnCamionetaFin->fecha_fin = now();
            $paquetesEnCamionetaFin->save();
        }

        $almacenContienePaquete = new AlmacenContienePaquete();
        $almacenContienePaquete->id_paquete = $request->id_paquete;
        $almacenContienePaquete->id_almacen = $request->id_almacen;
        $almacenContienePaquete->fecha_inicio = now();
        $almacenContienePaquete->save();

        return "paquete descargado en almacen" . $almacenContienePaquete->id_almacen ;
    }
}
