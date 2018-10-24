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
            $table->unsignedInteger('usuario_id');
            $table->timestamps();
            $table->softDeletes();

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
            $table->string('imagen');
            $table->string('nombre');
            $table->text('descripcion');
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('persona_id');
            $table->unsignedInteger('empresa_id');
            $table->unsignedInteger('costo_minimo');
            $table->unsignedInteger('costo_maximo');
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
            $table->timestamps();
            $table->softDeletes();
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
        // Schema::create('chat', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('licitacion_id');
        //     $table->timestamps();
        //     $table->softDeletes();
        // 
        //     $table->foreign('licitacion_id')->references('id')->on('licitacion')->onDelete('cascade');
        // });
        // Schema::create('conversacion', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('chat_id');
        //     $table->unsignedInteger('usuario_id');
        //     $table->text('conversacion');
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        //     $table->foreign('chat_id')->references('id')->on('chat')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio');
        Schema::dropIfExists('estatus');
        Schema::dropIfExists('valoracion');
        Schema::dropIfExists('calificacion');
        Schema::dropIfExists('oferta');
        Schema::dropIfExists('licitacion');
        // Schema::dropIfExists('evento');
        // Schema::dropIfExists('chat');
        // Schema::dropIfExists('conversacion');
    }
}