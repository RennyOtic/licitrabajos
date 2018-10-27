<?php

use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Models\Servicio::create(['nombre' => 'Carpinteros']);
        App\Models\Servicio::create(['nombre' => 'Gasfoter']);
    	App\Models\Servicio::create(['nombre' => 'Maestros de la Construccion']);
    }
}
