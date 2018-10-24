<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisologiaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('rol', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->time('desde_at')->nullable();
            $table->time('hasta_at')->nullable();
            $table->boolean('especial')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rol_usuario', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned()->index();
            $table->integer('rol_id')->unsigned()->index();

            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('rol')->onDelete('cascade');
            $table->primary(['usuario_id', 'rol_id']);
        });

        Schema::create('permiso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('modulo'); // users | rol ..
            $table->string('accion'); // index | show | store | update | destroy
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permiso_rol', function (Blueprint $table) {
            $table->integer('rol_id')->unsigned()->index();
            $table->integer('permiso_id')->unsigned()->index();

            $table->foreign('rol_id')->references('id')->on('rol')->onDelete('cascade');
            $table->foreign('permiso_id')->references('id')->on('permiso')->onDelete('cascade');
            $table->primary(['rol_id', 'permiso_id']);
        });

        Schema::create('permiso_usuario', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned()->index();
            $table->integer('permiso_id')->unsigned()->index();

            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('permiso_id')->references('id')->on('permiso')->onDelete('cascade');
            $table->primary(['usuario_id', 'permiso_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permiso_usuario');
        Schema::dropIfExists('permiso_rol');
        Schema::dropIfExists('permiso');
        Schema::dropIfExists('rol_usuario');
        Schema::dropIfExists('rol');
    }
}