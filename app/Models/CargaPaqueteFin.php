<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaPaqueteFin extends Model
{
    use HasFactory;

    protected $table = "carga_paquete_fin";

    public $timestamps = false;
    protected $fillable = [

        "id"

    ];
}
