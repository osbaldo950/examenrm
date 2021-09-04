<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->text('nombre')->nullable();
            $table->text('razon_social')->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('calle', 255)->nullable();
            $table->integer('numero_exterior')->nullable();
            $table->integer('numero_interior')->nullable();
            $table->string('colonia', 255)->nullable();
            $table->string('localidad', 255)->nullable();
            $table->string('telefonos', 255)->nullable();
            $table->string('correo', 255)->nullable();
            $table->text('status', 10)->nullable();
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
        Schema::dropIfExists('empresas');
    }
}
