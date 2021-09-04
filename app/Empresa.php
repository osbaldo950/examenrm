<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public $timestamps = false;
    protected $table = 'empresas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre', 
        'razon_social',
        'rfc',
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'localidad',
        'telefonos',
        'correo',
        'status'
    ];
}
