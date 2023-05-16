<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;


class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Marca::create([
            'nombre' => 'TEMCO',
            'estado' => 'Activo',
            'logo_src' => '',
        ]);

        Marca::create([
            'nombre' => 'CTI',
            'estado' => 'Activo',
            'logo_src' => '',
        ]);

        Marca::create([
            'nombre' => 'ECOM',
            'estado' => 'Activo',
            'logo_src' => '',
        ]);

    }
}

