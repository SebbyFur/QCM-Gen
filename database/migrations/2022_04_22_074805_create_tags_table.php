<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tags;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
        });

        Tags::insert(['tag' => 'C']);
        Tags::insert(['tag' => 'C++']);
        Tags::insert(['tag' => 'C#']);
        Tags::insert(['tag' => 'Go']);
        Tags::insert(['tag' => 'Python']);
        Tags::insert(['tag' => 'Laravel']);
        Tags::insert(['tag' => 'Eloquent']);
        Tags::insert(['tag' => 'Javascript']);
        Tags::insert(['tag' => 'HTML']);
        Tags::insert(['tag' => 'CSS']);
        Tags::insert(['tag' => 'UML']);
        Tags::insert(['tag' => 'Typescript']);
        Tags::insert(['tag' => 'Lua']);
        Tags::insert(['tag' => 'Java']);
        Tags::insert(['tag' => 'SQL']);
        Tags::insert(['tag' => 'Ruby']);
        Tags::insert(['tag' => 'HTTP']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
