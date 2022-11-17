<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('anticipos');
        
        Schema::create('anticipos', function (Blueprint $table) {
            $table->id();
            $table->string('valorAnticipo', 50);
            $table->text('descripcion');
            $table->smallInteger('legalizado')->nullable();
            $table->integer('avance_id')->unsigned();
            $table->foreign('avance_id')->references('id')->on('avances');
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
        Schema::dropIfExists('anticipos');
    }
}
