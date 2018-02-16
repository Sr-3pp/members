<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('telefono');
            $table->string('celular')->nullable();
            $table->string('website')->nullable();
            $table->string('foto')->default('media/img/defaults/profile_1.jpg');
            $table->string('fb')->nullable();
            $table->string('tw')->nullable();
            $table->string('in')->nullable();
            $table->string('programas')->nullable();
            $table->integer('pais_id');
            $table->string('ciudad')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('idiomas');
            $table->longText('educacion');
            $table->longText('resumen');
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
        Schema::dropIfExists('perfils');
    }
}
