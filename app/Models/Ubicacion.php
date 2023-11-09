<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = "ubicacion";

    public $timestamps = false;
    protected $fillable = [

        "direccion",
        "codigo_postal",
        "latitud",
        "longitud"

    ];

}
