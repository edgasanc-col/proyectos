<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('organizacions');

        Schema::create('organizacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nit')->unique();
            $table->string('nombreOrganizacion', 150);
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
        Schema::dropIfExists('organizacions');
    }
}
