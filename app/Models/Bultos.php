<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bultos extends Model
{
    use HasFactory;

    protected $table = "bulto";

    public $timestamps = false;
    protected $fillable = [

        "volumen",
        "peso",
        "almacen_destino"

    ];
}
