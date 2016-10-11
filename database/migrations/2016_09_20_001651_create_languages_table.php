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

            $table->double('tlpc_multiplier')->nullable();// Multiplier Time Limit Per Case 
            $table->double('ttl_multiplier')->nullable();// Multiplier Total Time Limit
            $table->double('ml_multiplier')->nullable(); // Multiplier Memory Limit
            $table->double('sl_multiplier')->nullable();// Multiplier Size Limit (size of file)
        });
        //Pivot table to manage the relationship many to many between laguages and problems

        Schema::create('language_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned();
            $table->integer('problem_id')->unsigned();

            $table->double('tlpc_multiplier')->nullable();// Multiplier Time Limit Per Case 
            $table->double('ttl_multiplier')->nullable();// Multiplier Total Time Limit
            $table->double('ml_multiplier')->nullable(); // Multiplier Memory Limit
            $table->double('sl_multiplier')->nullable();

            $table->double('tlpc')->nullable();// Time Limit Per Case
            $table->double('ttl')->nullable();// Total Time Limit
            $table->integer('ml')->unsigned()->nullable();//Memory Limit
            $table->integer('sl')->unsigned()->nullable();// Size Limit (size of file)

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
