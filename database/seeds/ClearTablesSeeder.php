<?php

use Illuminate\Database\Seeder;

class ClearTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('usuario')->truncate();
        DB::table('rol')->truncate();
        DB::table('rol_usuario')->truncate();
        DB::table('permiso')->truncate();
        DB::table('permiso_rol')->truncate();
        DB::table('permiso_usuario')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
