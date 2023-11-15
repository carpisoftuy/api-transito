<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenContieneBulto extends Model
{
    use HasFactory;

    protected $table = "almacen_contiene_bulto";

    public $timestamps = false;
    protected $fillable = [

        "id_bulto",
        "id_almacen"

    ];
}
