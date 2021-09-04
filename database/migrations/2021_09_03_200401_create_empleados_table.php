<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->integer('id_departamento')->nullable();
            $table->string('nombre', 255)->nullable();
            $table->dateTime('fecha_nacimiento')->nullable();
            $table->string('correo', 255)->nullable();
            $table->string('genero', 25)->nullable();
            $table->string('telefono', 255)->nullable();
            $table->string('celular', 255)->nullable();
            $table->dateTime('fecha_ingreso')->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
