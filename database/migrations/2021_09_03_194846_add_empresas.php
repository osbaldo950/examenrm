<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('empresas')->insert(array(
            'nombre' => 'Empresa A',
            'razon_social' => 'Empresa A',
            'rfc' => '',
            'calle' => '',
            'numero_exterior' => 1,
            'numero_interior' => 1,
            'colonia' => '',
            'localidad' => '',
            'telefonos' => '',
            'correo' => '',
            'status' => 'ALTA'
        ));

        DB::table('empresas')->insert(array(
            'nombre' => 'Empresa B',
            'razon_social' => 'Empresa B',
            'rfc' => '',
            'calle' => '',
            'numero_exterior' => 1,
            'numero_interior' => 1,
            'colonia' => '',
            'localidad' => '',
            'telefonos' => '',
            'correo' => '',
            'status' => 'ALTA'
        ));

        DB::table('empresas')->insert(array(
            'nombre' => 'Empresa C',
            'razon_social' => 'Empresa C',
            'rfc' => '',
            'calle' => '',
            'numero_exterior' => 1,
            'numero_interior' => 1,
            'colonia' => '',
            'localidad' => '',
            'telefonos' => '',
            'correo' => '',
            'status' => 'ALTA'
        ));

        DB::table('empresas')->insert(array(
            'nombre' => 'Empresa D',
            'razon_social' => 'Empresa D',
            'rfc' => '',
            'calle' => '',
            'numero_exterior' => 1,
            'numero_interior' => 1,
            'colonia' => '',
            'localidad' => '',
            'telefonos' => '',
            'correo' => '',
            'status' => 'ALTA'
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
