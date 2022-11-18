<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citatorios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_docente');
            $table->unsignedBigInteger('id_estudiante');
            $table->string('descripcion');
            $table->string('fecha');
            $table->foreign('id_docente')->references('id')->on('docentes');
            $table->foreign('id_estudiante')->references('id')->on('estudiantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citatorios', function (Blueprint $table) {
            Schema::dropIfExists('citatorios');
        });
    }
}
