<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judgments', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('submitted_at');
            $table->string('language',8);
            $table->integer('memory');
            $table->integer('time');
            $table->string('judgment',40); // the submit´s verdict
            $table->integer('file_size');

            $table->integer('problem_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->boolean('contest')->default('0'); // Indicates whether the judgment belongs to a contest
            $table->integer('contest_id')->unsigned()->nullable();

            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');

            //$table->timestamps();
        });
    }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('judgments');
    }
}
