<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',8);
        });
        //Pivot table to manage the relationship many to many between laguages and problems

        Schema::create('language_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned();
            $table->integer('problem_id')->unsigned();
            $table->double('multiplier');// multiplier uses for the TL, of the different languages

            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('problem_id')->references('id')->on('problems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_problem');
        Schema::dropIfExists('languages');
    }
}
