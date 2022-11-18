<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTutoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes_tutores_legales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tutor_legal');
            $table->unsignedBigInteger('id_estudiante');
            $table->foreign('id_tutor_legal')->references('id')->on('tutores_legales');
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
        Schema::table('estudiantes_tutores_legales', function (Blueprint $table) {
            Schema::dropIfExists('estudiantes_tutores_legales');
        });
    }
}
