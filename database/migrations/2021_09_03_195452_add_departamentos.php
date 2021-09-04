<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('departamentos')->insert(array(
            'id_empresa' => 1,
            'nombre' => 'Compras',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 1,
            'nombre' => 'Sistemas',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 2,
            'nombre' => 'Ventas',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 2,
            'nombre' => 'Compras',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 2,
            'nombre' => 'Desarrollo',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 3,
            'nombre' => 'Compras',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 3,
            'nombre' => 'Desarrollo',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 3,
            'nombre' => 'Contabilidad',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 3,
            'nombre' => 'Ventas',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 3,
            'nombre' => 'Produccion',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 4,
            'nombre' => 'Calidad',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 4,
            'nombre' => 'Compras',
            'status' => 'ALTA'
        ));

        DB::table('departamentos')->insert(array(
            'id_empresa' => 4,
            'nombre' => 'Produccion',
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
