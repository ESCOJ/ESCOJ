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
            $table->float('time');
            $table->string('judgment',40); // the submit´s verdict
            $table->integer('file_size');
            $table->integer('problem_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('problem_id')->references('id')->on('problems');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('judgments');
    }
}
