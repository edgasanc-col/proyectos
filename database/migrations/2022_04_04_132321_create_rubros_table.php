<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rubros');
        
        Schema::create('rubros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreRubro', 150);
            $table->string('codigoContable', 150);
            $table->smallInteger('variasFuentes');//Si o no
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
        Schema::dropIfExists('rubros');
    }
}
