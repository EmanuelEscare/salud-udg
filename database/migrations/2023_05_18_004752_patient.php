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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->string('invoice')->nullable();
            $table->string('code');
            $table->enum('sex', ['female', 'male', 'other']);
            $table->string('career')->nullable();
            $table->enum('civil_status', ['Soltero/a', 'Casado/a'])->nullable();
            $table->integer('average')->nullable();
            $table->integer('semester')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->boolean('depression')->nullable();
            $table->boolean('anxiety')->nullable();
            $table->boolean('panic_attack')->nullable();
            $table->boolean('treatment')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
