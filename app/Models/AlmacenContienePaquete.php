<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenContienePaquete extends Model
{
    use HasFactory;

    protected $table = "almacen_contiene_paquete";

    public $timestamps = false;
    protected $fillable = [

        "id_paquete",
        "id_almacen"

    ];
}
