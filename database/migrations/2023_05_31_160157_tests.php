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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->enum('test', 
            ['Inventario de Depresión de Beck (BDI-2)',
            'SCL-90-R',
            'Inventario de Ansiedad de Beck',
            'Escala de Estrés Percibido (PSS, Perceived Stress Scale)',
            'Escala de ansiedad de Hamilton']);
            $table->foreignId('patient_id')
                ->references('id')->on('patients')
                ->onDelete('cascade');
            $table->json('diagnostic')->nullable();
            $table->json('result');
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
        Schema::dropIfExists('tests');
    }
};
