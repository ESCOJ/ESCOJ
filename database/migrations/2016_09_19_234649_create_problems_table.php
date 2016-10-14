<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('ml')->unsigned()->nullable();//Memory Limit
            $table->integer('sl')->unsigned()->nullable();// Size Limit (size of file)
            $table->integer('tlpc')->unsigned()->nullable();// Time Limit Per Case
            $table->integer('ttl')->unsigned()->nullable();// Total Time Limit
            $table->mediumText('description');
            $table->text('input_specification');
            $table->text('output_specification');
            $table->string('sample_input',1000);
            $table->string('sample_output',1000);
            $table->string('hints',1000);
            $table->double('points')->nullable();
            $table->string('status',2)->nullable();//Indicates when the problem is available or disabled for the 24 hrs archive
            $table->string('slug')->nullable();
            $table->timestamps();

            $table->integer('source_id')->unsigned();
            $table->integer('added_by')->unsigned();

            $table->foreign('added_by')->references('id')->on('users');
            $table->foreign('source_id')->references('id')->on('sources');


        });
        
        //Pivot table to manage the relationship many to many between problems and tags
        Schema::create('problem_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level',2);
            $table->integer('problem_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('problem_id')->references('id')->on('problems');
            $table->foreign('tag_id')->references('id')->on('tags');
        });

        //Pivot table to manage the relationship many to many between problems and users
        Schema::create('problem_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status',3); // indicates the status of a problem respect to a user
            $table->integer('problem_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('problem_id')->references('id')->on('problems');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problem_tag');
        Schema::dropIfExists('problem_user');
        Schema::dropIfExists('problems');
    }
}
