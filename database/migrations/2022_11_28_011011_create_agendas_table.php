<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->integer('id_agendas')->autoIncrement()->comment('Llave principal');
            $table->string('nombre', 100)->nullable()->comment('Nombre');
            $table->char('telefono', 20)->nullable()->comment('Numero telefonico');
            $table->date('fecha_nacimiento')->nullable()->comment('Fecha de nacimiento');
            $table->char('direccion', 50)->nullable()->comment('Direccion');
            $table->string('correo', 100)->nullable()->comment('correo electronico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendas');
    }
}
