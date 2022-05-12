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
        Schema::create('mcq_structure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_question')->references('id')->on('questions');
            $table->foreignId('id_answer')->references('id')->on('answers');
            $table->foreignId('id_mcq')->references('id')->on('mcq_generator');
            $table->integer('choice')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcq_structure');
    }
};
