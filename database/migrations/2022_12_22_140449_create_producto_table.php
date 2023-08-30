<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 250)->nullable();
            $table->string('sku', 10)->nullable();
            //----------------------------------------------------
            $table->string ('OEM', 50)->nullable();
            $table->string('lote', 20)->nullable();
            $table->string('nombre', 250)->nullable();
            $table->string('descripcion', 5000)->nullable();  
            
            //relacionar con la tabla marca
            $table->integer('marca_id')->unsigned()->nullable();
            $table->foreign('marca_id')->references('id')->on('marca');

            $table->string('origen', 100)->nullable();
            //relacionar con la tabla categoria
            $table->integer('categoria_id')->unsigned()->nullable();
            $table->foreign('categoria_id')->references('id')->on('categoria');

            $table->string('ref_1', 20)->nullable();
            $table->string('ref_2', 20)->nullable();
            $table->string('ref_3', 20)->nullable();
            $table->integer('existencia')->unsigned()->nullable();
            $table->integer('existencia_limite')->unsigned()->nullable();
            $table->string('garantia', 100)->nullable();
            $table->string('ubicacion_bodega', 255)->nullable();
            $table->string('ubicacion_oficina', 255)->nullable();
            $table->string('unidad_por_caja', 10)->nullable();
            //Campos para control el volumen y peso del producto
            $table->decimal('volumen', 8,4)->nullable();
            $table->string('unidad_volumen', 10)->nullable();
            $table->decimal('peso', 8, 4)->nullable();
            $table->string('unidad_peso', 10)->nullable();
            $table->decimal('precio_distribuidor', 8, 2)->nullable();
            $table->decimal('precio_taller', 8, 2)->nullable();
            $table->decimal('precio_1', 8, 2)->nullable();
            $table->decimal('precio_2', 8, 2)->nullable();
            $table->decimal('precio_3', 8, 2)->nullable();
            $table->decimal('precio_oferta', 8, 2)->nullable();
            $table->string('hoja_seguridad', 250)->nullable();
            $table->string('ficha_tecnica_href', 250)->nullable();
            $table->string('imagen_1_src', 250)->nullable();
            $table->string('imagen_2_src', 250)->nullable();
            $table->string('imagen_3_src', 250)->nullable();
            $table->string('imagen_4_src', 250)->nullable();
            
            //relacionar con la tabla estado_producto
            $table->integer('estado_producto_id')->unsigned()->nullable()->default(1);;
            $table->foreign('estado_producto_id')->references('id')->on('estado_producto');
            
            $table->boolean('etiqueta_destacado')->nullable();
            $table->date('fecha_ingreso')->nullable();
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
        Schema::dropIfExists('producto');
    }
};
