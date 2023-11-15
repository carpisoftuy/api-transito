<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaPaquete extends Model
{
    use HasFactory;
    protected $table = 'carga_paquete';

    protected $fillable = [
        'id_paquete',
        'id_vehiculo'
    ];
}
