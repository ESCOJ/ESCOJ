<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('organization_id')->unsigned();
            $table->integer('added_by')->unsigned();
            $table->integer('penalization'); // penalization time 
            $table->integer('frozen_time'); //  time during the score is frozen
            $table->enum('access_type',['public', 'private']); // Indicates whether the contest is private or not
            $table->mediumText('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->boolean('offcontest')->default('0'); // Indicates whether the contest is in real time or not
            $table->integer('offcontest_penalization')->nullable(); // penalization time 
            $table->dateTime('offcontest_start_date')->nullable();
            $table->dateTime('offcontest_end_date')->nullable();

            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('added_by')->references('id')->on('users');
            
        });

        //Pivot table to manage the relationship many to many between contests and problems

        Schema::create('contest_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->unsigned();
            $table->integer('problem_id')->unsigned();
            $table->string('letter_id',1); // indicates the letter_id of a problem

            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
        });

        //Pivot table to manage the relationship many to many between contests and users
        Schema::create('contest_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');;
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
        Schema::dropIfExists('contest_user');
        Schema::dropIfExists('contest_problem');
        Schema::dropIfExists('contests');
    }
}
