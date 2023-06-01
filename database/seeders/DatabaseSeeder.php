<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EstadoProducto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
         
        $this->call(RolSeeder::class);
        $this->call(PermisoSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(EstadoProductoSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(CMSSeeder::class);

    }
}
