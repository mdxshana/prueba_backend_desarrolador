<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tipo_documento_id');
            $table->string('n_documento', 11);
            $table->string('nombres',100);
            $table->string('apellidos',100);
            $table->string('email',120);
            $table->string('telefono',11);
            $table->string('direccion',100);
            $table->foreign('tipo_documento_id')
                ->references('id')
                ->on('tipo_documentos')
                ->onDelete('cascade');
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
        Schema::dropIfExists('personas');
    }
}
