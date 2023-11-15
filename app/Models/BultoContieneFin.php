<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BultoContieneFin extends Model
{
    use HasFactory;

    protected $table = "bulto_contiene_fin";

    public $timestamps = false;
    protected $fillable = [

        "id"

    ];
}
