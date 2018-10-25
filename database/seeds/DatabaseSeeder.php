<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearTablesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserRootSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(EstatusSeeder::class);
        $this->call(ServicioSeeder::class);

        factory(\App\Usuario::class, 17)->create();
        factory(\App\Models\Permisologia\Rol::class, 17)->create();

    }
}
