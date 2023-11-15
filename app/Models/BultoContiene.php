<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BultoContiene extends Model
{
    use HasFactory;

    protected $table = "bulto_contiene";

    public $timestamps = false;
    protected $fillable = [

        "id_paquete",
        "id_bulto"

    ];
}
