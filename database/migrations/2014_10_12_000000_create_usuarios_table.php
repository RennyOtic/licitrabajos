<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->boolean('notificaciones')->default(true);
            $table->integer('identificacion')->unsigned()->unique();
            $table->string('correo', 50)->unique();
            $table->string('password')->nullable();
            $table->string('pais')->nullable();
            $table->string('municipio')->nullable();
            $table->string('sector')->nullable();
            $table->string('calle_avenida')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
