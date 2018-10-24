<?php

use Illuminate\Database\Seeder;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //estatus
        \App\Models\Estatus::create(['nombre' => 'Evaluando Propuesta']);
        \App\Models\Estatus::create(['nombre' => 'Aceptar Propuesta']);
        \App\Models\Estatus::create(['nombre' => 'Rechazar Propuesta']);
    }
}
