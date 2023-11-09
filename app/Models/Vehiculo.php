<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = "vehiculo";

    public $timestamps = false;
    protected $fillable = [

        "codigo_pais",
        "matricula",
        "capacidad_volumen",
        "capacidad_peso",
        "peso_ocupado",
        "volumen_ocupado"

    ];
}
