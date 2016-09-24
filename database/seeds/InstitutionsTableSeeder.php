<?php

use Illuminate\Database\Seeder;
use ESCOJ\Institution;

class InstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Institution::create(array(
            'name' => 'Escuela Superior De Computo',
            'country_id' => '1',
        ));

        Institution::create(array(
            'name' => 'Universidad Autonoma de Mexico',
            'country_id' => '1',
        )); 

        Institution::create(array(
            'name' => 'Instituto Tecnologico de Monterrey',
            'country_id' => '1',
        ));

        Institution::create(array(
            'name' => 'Harvard',
            'country_id' => '2',
        ));

        Institution::create(array(
            'name' => 'MIT',
            'country_id' => '2',
        ));

        Institution::create(array(
            'name' => 'Universidad china',
            'country_id' => '3',
        ));

        Institution::create(array(
            'name' => 'Universidad japonesa',
            'country_id' => '4',
        ));

        Institution::create(array(
            'name' => 'Universidad del tourist XD',
            'country_id' => '5',
        ));
   
    }
}
