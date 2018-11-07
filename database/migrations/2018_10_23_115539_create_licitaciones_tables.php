<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicitacionesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('servicio_usuario', function (Blueprint $table) {
            $table->unsignedInteger('servicio_id');
            $table->unsignedInteger('usuario_id');

            $table->foreign('servicio_id')->references('id')->on('servicio')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        });
        Schema::create('estatus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('licitacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imagen')->nullable();
            $table->string('nombre');
            $table->string('slug');
            $table->text('descripcion');
            $table->text('comentario')->nullable();
            $table->unsignedInteger('evaluacion')->nullable();
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('servicio_id');
            $table->unsignedInteger('persona_id');
            $table->unsignedInteger('empresa_id')->nullable();
            $table->unsignedInteger('precio_minimo');
            $table->unsignedInteger('precio_maximo');
            $table->unsignedInteger('tiempo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->references('id')->on('estatus')->onDelete('cascade');
            $table->foreign('persona_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('usuario')->onDelete('cascade');
        });
        Schema::create('valoracion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('calificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('valoracion_id');
            $table->unsignedInteger('licitacion_id');
            $table->text('comentario');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('valoracion_id')->references('id')->on('valoracion')->onDelete('cascade');
            $table->foreign('licitacion_id')->references('id')->on('licitacion')->onDelete('cascade');
        });
        Schema::create('oferta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('licitacion_id');
            $table->unsignedInteger('usuario_id');
            $table->text('propuesta');
            $table->unsignedInteger('estatus_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('licitacion_id')->references('id')->on('licitacion')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('estatus_id')->references('id')->on('estatus')->onDelete('cascade');
        });
        // Schema::create('evento', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('usuario_id');
        //     $table->unsignedInteger('licitacion_id');
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        //     $table->foreign('licitacion_id')->references('id')->on('licitacion')->onDelete('cascade');
        // });
        Schema::create('chat', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('licitacion_id');
            $table->unsignedInteger('persona_id');
            $table->unsignedInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('licitacion_id')->references('id')->on('licitacion')->onDelete('cascade');
            $table->foreign('persona_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('usuario')->onDelete('cascade');
        });
        Schema::create('mensaje', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('chat_id');
            $table->unsignedInteger('usuario_id');
            $table->text('mensaje');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('chat_id')->references('id')->on('chat')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_usuario');
        Schema::dropIfExists('servicio');
        Schema::dropIfExists('estatus');
        Schema::dropIfExists('valoracion');
        Schema::dropIfExists('calificacion');
        Schema::dropIfExists('oferta');
        Schema::dropIfExists('licitacion');
        // Schema::dropIfExists('evento');
        Schema::dropIfExists('chat');
        Schema::dropIfExists('mensaje');
    }
}