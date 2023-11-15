<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Bulto;
use App\Models\BultoDesarmado;
use App\Models\BultoContiene;
use App\Models\BultoContieneFin;
use App\Models\CargaBulto;
use App\Models\CargaBultoFin;
use App\Models\AlmacenContieneBulto;
use App\Models\AlmacenContienePaquete;

class BultosController extends Controller
{
    public function GetBultosCargadosEnCamion(Request $request){
        $bultos = Bulto::join('carga_bulto', 'carga_bulto.id_bulto', '=', 'bulto.id')
        ->whereNotIn('carga_bulto.id',
            DB::table('carga_bulto_fin')
            ->select('id')
        )
        ->join('vehiculo', 'vehiculo.id', '=', 'carga_bulto.id_vehiculo')
        ->where('vehiculo.id', '=', $request->id)
        ->select('*', 'carga_bulto.id')
        ->get();

        return $bultos;
    }

    public function DescargarBulto(Request $request){
        DB::beginTransaction();

        $bultoEnCamion = CargaBulto::where('carga_bulto.id_bulto', '=', $request->id_bulto)
        ->whereNotIn('carga_bulto.id',
            DB::table('carga_bulto_fin')
            ->select('id')
        )
        ->join('bulto', 'bulto.id', '=', 'carga_bulto.id_bulto')
        ->select('carga_bulto.id', 'bulto.almacen_destino')
        ->first();

        $bultosEnCamionFin = new CargaBultoFin();
        $bultosEnCamionFin->id = $bultoEnCamion->id;
        $bultosEnCamionFin->fecha_fin = now();
        $bultosEnCamionFin->save();


        if($bultoEnCamion->almacen_destino != $request->id_almacen){
            $almacenContieneBulto = new AlmacenContieneBulto();
            $almacenContieneBulto->id_bulto = $request->id_bulto;
            $almacenContieneBulto->id_almacen = $request->id_almacen;
            $almacenContieneBulto->fecha_inicio = now();
            $almacenContieneBulto->save();
            DB::commit();
            return "bulto descargado en almacen " . $almacenContieneBulto->id_almacen;
        }

        $paquetesContenidos = BultoContiene::where('bulto_contiene.id_bulto', '=', $request->id_bulto)
        ->whereNotIn('bulto_contiene.id',
            DB::table('bulto_contiene_fin')
            ->select('id')
        )
        ->get();

        foreach($paquetesContenidos as $paquete){
            $paqueteEnBultoFin = new BultoContieneFin();
            $paqueteEnBultoFin->id = $paquete->id;
            $paqueteEnBultoFin->fecha_fin = now();
            $paqueteEnBultoFin->save();

            $almacenContienePaquete = new AlmacenContienePaquete();
            $almacenContienePaquete->id_paquete = $paquete->id_paquete;
            $almacenContienePaquete->id_almacen = $request->id_almacen;
            $almacenContienePaquete->fecha_inicio = now();
            $almacenContienePaquete->save();
        }

        $bultoDesarmado = new BultoDesarmado();
        $bultoDesarmado->id = $request->id_bulto;
        $bultoDesarmado->fecha_desarmado = now();
        $bultoDesarmado->save();

        DB::commit();
        return "bulto entregado en su destino";
    }
}
