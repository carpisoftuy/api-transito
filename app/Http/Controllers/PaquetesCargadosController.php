<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaquetesCargadosController extends Controller
{
    public function MostrarPaquetesCargados(Request $request){

        $paquetes_finalizados = DB::table('carga_paquete_fin')
        ->select('id');
        
        $paquetes_en_transito = DB::table('carga_paquete')
        ->select('paquete.id', 'paquete.peso', 'paquete.volumen', 'ubicacion.direccion', 'ubicacion.codigo_postal', 'ubicacion.latitud', 'ubicacion.longitud')
        ->join('paquete', 'carga_paquete.id_paquete', '=', 'paquete.id')
        ->join('camioneta', 'carga_paquete.id_vehiculo', '=', 'camioneta.id')
        ->join('vehiculo', 'camioneta.id', '=', 'vehiculo.id')
        ->join('maneja', 'maneja.id_vehiculo', '=', 'vehiculo.id')
        ->join('chofer', 'chofer.id', '=', 'maneja.id_usuario')
        ->join('usuario', 'usuario.id', '=', 'chofer.id')
        ->join('paquete_para_entregar', 'paquete_para_entregar.id', '=', 'paquete.id')
        ->join('ubicacion', 'paquete_para_entregar.ubicacion_destino', '=', 'ubicacion.id')
        ->whereNotIn('carga_paquete.id', $paquetes_finalizados)
        ->where('camioneta.id', '=', $request->id)
        ->get();

        return $paquetes_en_transito;
    }

    public function EntregarPaquete(Request $request){

        $paquetes_entregados = DB::table('paquete_entregado')
        ->insert(['id' => $request->post('id')]);

        $id_variable = DB::table('carga_paquete')
        ->select('carga_paquete.id')
        ->where('id_paquete' , '=', $request->post('id'))
        ->first();

        DB::table('carga_paquete_fin')
        ->insert(['id'=>$id_variable->id]);

        return 'paquete entregado con exito';
    }

    public function MostrarPaquetesEntregados(Request $request){

        $paquetes_entregados = DB::table('paquete_entregado')
        ->select('paquete_entregado.id', 'paquete_entregado.fecha_entregado')
        ->get();

        return $paquetes_entregados;
    }

    public function MostrarPaquetesParaEntregar(Request $request){

        $paquetes_para_entregar = DB::table('paquete_para_entregar')
        ->select('paquete_para_entregar.id', 'paquete_para_entregar.ubicacion_destino')
        ->get();

        return $paquetes_para_entregar;

    }

    public function DetallePaquete($id){

        $detalle_paquete = DB::table('paquete_para_entregar')
        ->select('paquete_para_entregar.id', 'paquete_para_entregar.ubicacion_destino', 'paquete.peso', 'ubicacion.direccion', 'ubicacion.codigo_postal')
        ->join('paquete', 'paquete_para_entregar.id', '=', 'paquete.id')
        ->join('ubicacion', 'paquete_para_entregar.ubicacion_destino', '=', 'ubicacion.id')
        ->where('paquete_para_entregar.id', '=', $id)
        ->get();

        return $detalle_paquete;

    } 

}
