<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutoresLegalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutores_legales', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nombre');
            $table->string('aPaterno');
            $table->string('aMaterno');
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tutores_legales', function (Blueprint $table) {
            Schema::dropIfExists('tutores_legales');
        });
    }
}
