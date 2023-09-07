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
            $table->string('notas_bodega', 255);
            $table->string('visto', 18); //nuevo, visto
            $table->string('corr', 25); //# factura
            $table->string('ubicacion', 20);
            $table->string('bulto', 10);
            $table->string('paleta', 10);
            $table->string('factura_href', 200); //factura
            $table->string('hoja_salida_href', 200); //hoja de salida
            $table->string('comprobante_pago_href', 250); //comprobante de pago

            comprobante_pago_href
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
