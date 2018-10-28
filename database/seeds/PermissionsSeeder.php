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
            'nombre' => 'Evaluar Trabajo Licitacion',
            'modulo' => 'tender',
            'accion' => 'store',
            'descripcion' => 'Permiso para Evaluar Trabajo Licitacion'
        ]);

        // App\Models\Permisologia\Permiso::create([
        //     'nombre' => 'Ver Licitacion',
        //     'modulo' => 'tender',
        //     'accion' => 'show',
        //     'descripcion' => 'Permiso para ver un Licitacion'
        // ]);

        // App\Models\Permisologia\Permiso::create([
        //     'nombre' => 'Actualizar Licitacion',
        //     'modulo' => 'tender',
        //     'accion' => 'update',
        //     'descripcion' => 'Permiso para actualizar Licitacion'
        // ]);

        // App\Models\Permisologia\Permiso::create([
        //     'nombre' => 'Eliminar Licitacion',
        //     'modulo' => 'tender',
        //     'accion' => 'destroy',
        //     'descripcion' => 'Permiso para Eliminar Licitacion'
        // ]);

        /**
         * Permisos de Mis Licitaciones
         */
        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Mis Licitaciones',
            'modulo' => 'mytender',
            'accion' => 'index',
            'descripcion' => 'Permiso para ver Mis Licitaciones'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Crear Mis Licitacion',
            'modulo' => 'mytender',
            'accion' => 'store',
            'descripcion' => 'Permiso para registrar Mi Licitacion'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Mi Licitacion',
            'modulo' => 'mytender',
            'accion' => 'show',
            'descripcion' => 'Permiso para ver Mi Licitacion'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Actualizar Mi Licitacion',
            'modulo' => 'mytender',
            'accion' => 'update',
            'descripcion' => 'Permiso para actualizar Mi Licitacion'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Eliminar Mi Licitacion',
            'modulo' => 'mytender',
            'accion' => 'destroy',
            'descripcion' => 'Permiso para Eliminar Mi Licitacion'
        ]);

        /**
         * Permisos de Ofertas
         */
        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Ofertas',
            'modulo' => 'offer',
            'accion' => 'index',
            'descripcion' => 'Permiso para ver Ofertas'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Crear Oferta',
            'modulo' => 'offer',
            'accion' => 'store',
            'descripcion' => 'Permiso para registrar Oferta'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Ver Oferta',
            'modulo' => 'offer',
            'accion' => 'show',
            'descripcion' => 'Permiso para ver Oferta'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Actualizar Oferta',
            'modulo' => 'offer',
            'accion' => 'update',
            'descripcion' => 'Permiso para actualizar Mi Oferta'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Eliminar Oferta',
            'modulo' => 'offer',
            'accion' => 'destroy',
            'descripcion' => 'Permiso para Eliminar Mi Oferta'
        ]);

        App\Models\Permisologia\Permiso::create([
            'nombre' => 'Aceptar Oferta',
            'modulo' => 'offer',
            'accion' => 'accept',
            'descripcion' => 'Permiso para Aceptar Oferta'
        ]);

    }
}
