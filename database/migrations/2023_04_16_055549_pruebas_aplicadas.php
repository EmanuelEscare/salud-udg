<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pruebas_aplicadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostico_id')
                ->references('id')->on('diagnosticos')
                ->onDelete('cascade');
            $table->foreignId('prueba_id')
                ->references('id')->on('pruebas')
                ->onDelete('cascade');
            $table->string('url', 255);
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
        Schema::dropIfExists('pruebas_aplicadas');
    }
};
