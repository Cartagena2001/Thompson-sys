<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoProducto;


class EstadoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        EstadoProducto::create([
            'id' => '1',
            'estado' => 'Activo',
        ]);

        EstadoProducto::create([
            'id' => '2',
            'estado' => 'Inactivo',
        ]);

        EstadoProducto::create([
            'id' => '3',
            'estado' => 'Agotado',
        ]);

        EstadoProducto::create([
            'id' => '4',
            'estado' => 'En reserva',
        ]);



    }
}

