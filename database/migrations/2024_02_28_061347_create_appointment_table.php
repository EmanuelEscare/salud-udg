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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->enum('treatment', 
            ['Consejeria',
            'Diagnostico']);
            $table->enum('status', 
            ['pendiente',
            'asistio', 'no asistio']);
            $table->foreignId('patient_id')
                ->references('id')->on('patients')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->nullable();
            $table->json('diagnostic')->nullable();
            $table->string('observations',300)->nullable();
            $table->date('appointment_date');
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
        Schema::dropIfExists('appointment');
    }
};
