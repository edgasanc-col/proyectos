<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('permisos');
        
        Schema::create('permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->integer('modulo_id')->unsigned();
            $table->foreign('modulo_id')->references('id')->on('modulos');
            $table->smallInteger('crear');
            $table->smallInteger('ver');
            $table->smallInteger('editar');
            $table->smallInteger('borrar');
            $table->smallInteger('importar');
            $table->smallInteger('exportar');
            $table->integer('user_create')->unsigned();
            $table->foreign('user_create')->references('id')->on('users');
            $table->dateTime('created_at');
            $table->integer('user_update')->unsigned()->nullable();
            $table->foreign('user_update')->references('id')->on('users');
            $table->dateTime('updated_at')->nullable();
            $table->smallInteger('estado');
            $table->smallInteger('borrado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
