<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->string('name');
          $table->string('rango');
          $table->string('telefono');
          $table->string('website')->nullable();
          $table->string('foto')->default('/media/img/defaults/profile_1.png');
          $table->string('fb')->nullable();
          $table->string('tw')->nullable();
          $table->string('in')->nullable();
          $table->string('programas')->nullable();
          $table->integer('pais_id');
          $table->string('ciudad')->nullable();
          $table->string('nacionalidad')->nullable();
          $table->string('idiomas');
          $table->longText('cv');
          $table->longText('descripcion');
          $table->boolean('status')->default(0);
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
        Schema::dropIfExists('empresas');
    }
}
