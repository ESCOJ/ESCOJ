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
            $table->string('name');
            $table->string('author');
            $table->double('tlpc');// Time Limit Per Case
            $table->double('ttl');// Total Time Limit
            $table->integer('ml')->unsigned();//Memory Limit
            $table->integer('sl')->unsigned();// Size Limit (size of file)
            $table->mediumText('description');
            $table->text('input_specification');
            $table->text('output_specification');
            $table->string('sample_input',1000);
            $table->string('sample_output',1000);
            $table->string('hints',1000);
            $table->double('points');
            $table->string('status',2);//Indicates when the problem is available or disabled for the 24 hrs archive
            $table->string('slug')->nullable();
            $table->timestamps();

            $table->integer('added_by')->unsigned();
            $table->foreign('added_by')->references('id')->on('users');

        });
        
        //Pivot table to manage the relationship many to many between problems and tags
        Schema::create('problem_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level',2);
            $table->integer('problem_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('problem_id')->references('id')->on('problems');
            $table->foreign('problem_id')->references('id')->on('problems');       $table->foreign('tag_id')->references('id')->on('tags');
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
