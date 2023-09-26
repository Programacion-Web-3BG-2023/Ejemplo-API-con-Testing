<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Persona::factory(100)->create();
        \App\Models\Persona::factory(1)->create([
            "id" => "999",
            "nombre" => "Juan",
            "apellido" => "Perez"
        ]);

        \App\Models\Persona::factory(1)->create([
            "id" => "998",

        ]);

        \App\Models\Persona::factory(1)->create([
            "id" => "997",
        ]);

    }
}
