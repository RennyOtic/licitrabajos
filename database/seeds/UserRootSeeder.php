<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        
        $user = App\Usuario::create([
            'nombre' => 'Root',
            'apellido' => 'Root',
            'identificacion' => '99999999',
            'correo' => 'root@licitrabajos.com',
            'password' => bcrypt('secret'),
        ]);

        $rol = App\Models\Permisologia\Rol::create([
            'nombre' => 'Administrador',
            'slug' => 'SuperAdmin',
            'descripcion' => 'Acceso total a los Modulos.',
            'especial' => 1
        ]);

        DB::table('rol_usuario')->insert(['usuario_id' => $user->id, 'rol_id' => $rol->id]);

        $num = App\Models\Permisologia\Permiso::all()->count();
        $data = [];
        $data2 = [];
        for ($i = 1; $i <= $num; $i++) { 
            $data[] = ['rol_id' => $rol->id, 'permiso_id' => $i];
            $data2[] = ['usuario_id' => $user->id, 'permiso_id' => $i];
        }
        DB::table('permiso_rol')->insert($data);
        DB::table('permiso_usuario')->insert($data2);
    }
}
