<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->increments('id');
            //relacionar con la table envento
            //$table->integer('evento_id')->unsigned();
            $table->string('accion', 180);
            $table->foreign('evento_id')->references('id')->on('evento');
            //relacionar con la tabla usuario
            $table->integer('user_id')->unsigned();
            
            //campo para guardar la fecha y hora de la bitacora
            $table->dateTime('hora_fecha');
            $table->string('descripcion', 180);
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
        Schema::dropIfExists('bitacora');
    }
};
