<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creation of the user table
        Schema::create('users', function (Blueprint $table) {
           //Columns 
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('register_date');
            $table->enum('type',['contestant', 'coach', 'admin'])->default('contestant');
            $table->integer('institution_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->double('points')->default('0');
            $table->string('avatar')->default('user_default.jpg');
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();
            //Foreign keys
            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->foreign('country_id')->references('id')->on('countries');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Delete of the user table when the migrations rollbacks
        Schema::dropIfExists('users');
    }
}


