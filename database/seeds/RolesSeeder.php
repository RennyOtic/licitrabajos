<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Permisologia\Rol::create([
            'nombre' => 'Empresa',
            'slug' => 'company',
            'descripcion' => 'Rol para Empresas Registradas.',
        ]);

        App\Models\Permisologia\Rol::create([
            'nombre' => 'Persona',
            'slug' => 'persona',
            'descripcion' => 'Rol para Empresas Registradas.',
        ]);
    }
}
