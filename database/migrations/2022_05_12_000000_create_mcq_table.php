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
        Schema::create('mcq', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_model')->nullable()->default(NULL)->references('id')->on('mcq_model');
            $table->foreignId('id_tag')->nullable()->default(NULL)->references('id')->on('tags');
            $table->foreignId('id_exam')->nullable()->default(NULL)->references('id')->on('exam');
            $table->foreignId('id_student')->references('id')->on('students');
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
        Schema::dropIfExists('mcq');
    }
};
