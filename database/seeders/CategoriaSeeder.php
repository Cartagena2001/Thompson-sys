<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Categoria::create([
            'nombre' => 'Fajas',
            'estado' => 'Activo',
        ]);

        Categoria::create([
            'nombre' => 'Soportes',
            'estado' => 'Activo',
        ]);

        Categoria::create([
            'nombre' => 'Silicones',
            'estado' => 'Activo',
        ]);

        Categoria::create([
            'nombre' => 'Limpiadores',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Pegamentos',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Aerosoles',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Limpiadores',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Aditivos',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Liquidos',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Boutique',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Anticongelantes',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Equipos',
            'estado' => 'Activo',
        ]);
        Categoria::create([
            'nombre' => 'Fijadores',
            'estado' => 'Activo',
        ]);



    }
}

