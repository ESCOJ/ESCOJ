<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //Creation of the countries table
        Schema::create('countries', function (Blueprint $table) {
           //Columns 
            $table->increments('id');
            $table->string('name', 255)->default('');
            $table->string('full_name', 255)->nullable();
            $table->string('flag', 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Deletes the countries table when the migrations rollbacks
        Schema::dropIfExists('countries');
    }
}
