<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Evento::create([
            'nombre' => 'Inicio Sesión',   
            'descripcion' => 'Evento que registra el inicio de sesión de un usuario en el sistema.',  
        ]);

        Evento::create([
            'nombre' => 'Cierre Sesión',   
            'descripcion' => 'Evento que registra el cierre de sesión de un usuario en el sistema.',  
        ]);

        Evento::create([
            'nombre' => 'Compra',   
            'descripcion' => 'Evento de compra por parte de un cliente.',  
        ]);

    }
}

