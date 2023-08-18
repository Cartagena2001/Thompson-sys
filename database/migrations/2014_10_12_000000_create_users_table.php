<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('cliente_id_interno', 10)->nullable();
            $table->string('form_status', 15)->nullable();
            $table->string('direccion', 80)->nullable();
            $table->string('nombre_empresa', 35)->nullable();
            $table->string('razon_social', 35)->nullable();
            $table->string('giro', 200)->nullable();
            $table->string('municipio', 22)->nullable();
            $table->string('departamento', 15)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('website', 35)->nullable();
            $table->string('nit', 18)->nullable()->unique();
            $table->string('dui', 10)->nullable()->unique();
            $table->string('nrc', 10)->nullable()->unique();
            //relacionar con la tabla rol
            $table->integer('rol_id')->unsigned()->nullable();
            $table->foreign('rol_id')->references('id')->on('rol')->nullable();
            $table->string('estado', 10)->nullable();
            $table->string('clasificacion', 10)->nullable();
            $table->boolean('boletin')->nullable();
            $table->dateTime('fecha_registro')->nullable();
            $table->string('imagen_perfil_src', 60)->nullable();
            $table->string('marcas', 300)->nullable();
            $table->string('notas', 300)->nullable();
            $table->string('estatus', 15)->nullable();
            $table->string('visto', 18); //nuevo, visto

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
