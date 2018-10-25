<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Permisos de usuarios
         */
        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Usuarios',
            'modulo' => 'user',
            'accion' => 'index',
            'descripcion' => 'Permiso para Ver usuarios'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Crear Usuarios',
            'modulo' => 'user',
            'accion' => 'store',
            'descripcion' => 'Permiso para registrar usuarios'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Usuario',
            'modulo' => 'user',
            'accion' => 'show',
            'descripcion' => 'Permiso para Ver usuario'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Editar Usuarios',
            'modulo' => 'user',
            'accion' => 'update',
            'descripcion' => 'Permiso para editar usuarios'
        ]);

        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Borrar Usuarios',
        	'modulo' => 'user',
        	'accion' => 'destroy',
        	'descripcion' => 'Permiso para borrar usuarios'
        ]);

        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Cambiar usuario',
        	'modulo' => 'user',
        	'accion' => 'initWithOneUser',
        	'descripcion' => 'Permiso para Iniciar sesion con otro usuario'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Permitir Servivicios',
            'modulo' => 'user',
            'accion' => 'service',
            'descripcion' => 'Permiso para Permitir Agregar Servicios al usuario'
        ]);

        /**
         * Permisos de Roles
         */
        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Ver Roles',
        	'modulo' => 'rol',
        	'accion' => 'index',
        	'descripcion' => 'Permiso para ver roles'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Crear Roles',
            'modulo' => 'rol',
            'accion' => 'store',
            'descripcion' => 'Permiso para registrar roles'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Rol',
            'modulo' => 'rol',
            'accion' => 'show',
            'descripcion' => 'Permiso para ver un rol'
        ]);

        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Actualizar Roles',
        	'modulo' => 'rol',
        	'accion' => 'update',
        	'descripcion' => 'Permiso para actualizar roles'
        ]);

        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Eliminar Roles',
        	'modulo' => 'rol',
        	'accion' => 'destroy',
        	'descripcion' => 'Permiso para Eliminar roles'
        ]);

        /**
         * Permisos de Permisos
         */
        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Permisos',
            'modulo' => 'permission',
            'accion' => 'index',
            'descripcion' => 'Permiso para Ver Permisos'
        ]);

        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Ver Permiso',
        	'modulo' => 'permission',
        	'accion' => 'show',
        	'descripcion' => 'Permiso para Ver un Permiso'
        ]);

        App\Models\Permisologia\Permiso::create([
        	'nombre' => 'Modificar Permisos',
        	'modulo' => 'permission',
        	'accion' => 'update',
        	'descripcion' => 'Permiso para Eliminar Permisos'
        ]);

        /**
         * Permisos de Licitaciones
         */
        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Licitaciones',
            'modulo' => 'tender',
            'accion' => 'index',
            'descripcion' => 'Permiso para ver Licitaciones'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Crear Licitacion',
            'modulo' => 'tender',
            'accion' => 'store',
            'descripcion' => 'Permiso para registrar Licitacion'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Licitacion',
            'modulo' => 'tender',
            'accion' => 'show',
            'descripcion' => 'Permiso para ver un Licitacion'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Actualizar Licitacion',
            'modulo' => 'tender',
            'accion' => 'update',
            'descripcion' => 'Permiso para actualizar Licitacion'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Eliminar Licitacion',
            'modulo' => 'tender',
            'accion' => 'destroy',
            'descripcion' => 'Permiso para Eliminar Licitacion'
        ]);
    }
}
