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

        DB::select('INSERT INTO `permiso_rol` (`rol_id`, `permiso_id`) VALUES 
            (2, 7), (2, 16), (2, 20), (2, 23), (2, 24), (2, 25), (2, 26), (2, 27), (2, 29), (2, 30), (2, 31), (2, 32), (2, 33), (2, 34),
            (3, 16), (3, 17), (3, 18), (3, 19), (3, 20), (3, 21), (3, 22), (3, 28), (3, 32), (3, 33), (3, 34);');
        if (env('APP_ENV') == 'local') {
            factory(\App\Usuario::class, 17)->create();

            DB::select("INSERT INTO `licitacion` (`id`, `imagen`, `nombre`, `slug`, `descripcion`, `comentario`, `evaluacion`, `status_id`, `servicio_id`, `persona_id`, `empresa_id`, `precio_minimo`, `precio_maximo`, `tiempo`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, NULL, 'd qwd qwd qwd qwd qw', 'd-qwd-qwd-qwd-qwd-qw-1', 'qd qwdwq dqw dqw dqw dqw', NULL, NULL, 2, 3, 1, 2, 10, 20, 2, '2018-11-06 01:17:10', '2018-11-06 01:58:23', NULL),
                (2, NULL, 'dqwd qw dqwd qwdqw', 'dqwd-qw-dqwd-qwdqw', 'd qwdqwd qwdqw dqwd qw dqw d', NULL, NULL, 1, 2, 1, NULL, 15, 20, 2, '2018-11-06 01:44:38', '2018-11-06 01:44:38', NULL);");

            DB::select("INSERT INTO `oferta` (`id`, `licitacion_id`, `usuario_id`, `propuesta`, `estatus_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 1, 2, 'dq wdqwd qwdqw dqw dqwd qw dqw dqw dqw dqw dqw', 2, '2018-11-06 01:20:43', '2018-11-06 01:58:23', NULL);");

            DB::select("INSERT INTO `chat` (`id`, `licitacion_id`, `persona_id`, `empresa_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 1, 1, 2, '2018-11-06 01:52:19', '2018-11-06 01:52:19', NULL),
                (3, 1, 1, 4, '2018-11-06 02:04:05', '2018-11-06 02:04:05', NULL);");

            DB::select("INSERT INTO `permiso_usuario` (`usuario_id`, `permiso_id`) VALUES
                (2, 7), (2, 16), (2, 20), (2, 23), (2, 24), (2, 25), (2, 26), (2, 27), (2, 29), (2, 30), (2, 31), (2, 32), (2, 33), (2, 34);");

            DB::select("INSERT INTO `rol_usuario` (`usuario_id`, `rol_id`) VALUES (2, 2);");
            DB::select("INSERT INTO `servicio_usuario` (`servicio_id`, `usuario_id`) VALUES (3, 2);");

        }

    }
}