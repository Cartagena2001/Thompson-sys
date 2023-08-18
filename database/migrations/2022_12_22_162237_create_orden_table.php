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
        Schema::create('orden', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_registro');
            //relacionar con la tabla usuario
            $table->integer('user_id')->unsigned();
            $table->string('estado', 10);
            $table->dateTime('fecha_envio');
            $table->dateTime('fecha_entrega');
            $table->double('total', 7, 2);
            $table->string('notas', 255);
            $table->string('visto', 18); //nuevo, visto
            $table->string('cif', 25); //# factura
            $table->string('factura_href', 200); //# factura
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
        Schema::dropIfExists('orden');
    }
};
