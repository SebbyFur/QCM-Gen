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
        Schema::create('mcq_model_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_question')->references('id')->on('questions');
            $table->foreignId('id_model')->references('id')->on('mcq_model');
            $table->unique(['id_question', 'id_model']);
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
        Schema::dropIfExists('mcq_model_data');
    }
};