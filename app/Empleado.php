<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    
    public $timestamps = false;
    protected $table = 'empleados';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_departamento', 
        'nombre',
        'fecha_nacimiento',
        'correo',
        'genero',
        'telefono',
        'celular',
        'fecha_ingreso',
        'status'
    ];
}
