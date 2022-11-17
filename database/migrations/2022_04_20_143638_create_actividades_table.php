<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('actividades');

        Schema::create('actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreActividad', 200);
            $table->double('valorUnitario', 15,2);
            $table->integer('cantidad');
            $table->double('valorTotal', 15,2);
            $table->double('ponderacion',2,2);
            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->integer('resultado_id')->unsigned();
            $table->foreign('resultado_id')->references('id')->on('resultados');
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
        Schema::dropIfExists('actividades');
    }
}
