<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetaCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjeta_creditos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id');
            $table->string('numero_tarjeta',16);
            $table->string('vencimiento');
            $table->string('cvc',3);
            $table->foreign('persona_id')
                ->references('id')
                ->on('personas')
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
        Schema::dropIfExists('tarjeta_creditos');
    }
}
