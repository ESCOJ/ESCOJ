<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\Institution\Institution;

class InstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //México
        Institution::create(array(
            'name' => 'Escuela Superior De Cómputo - Instituto Politécnico Nacional',
            'country_id' => '1',
        ));
        Institution::create(array(
            'name' => 'Universidad Nacional Autónoma de México',
            'country_id' => '1',
        )); 
        Institution::create(array(
            'name' => 'Instituto Tecnológico de Monterrey',
            'country_id' => '1',
        ));

        //USA
        Institution::create(array(
            'name' => 'Harvard',
            'country_id' => '2',
        ));
        Institution::create(array(
            'name' => 'MIT',
            'country_id' => '2',
        ));
        Institution::create(array(
            'name' => 'Stanford',
            'country_id' => '2',
        ));

        //China
        Institution::create(array(
            'name' => 'Universidad Politécnica de Hong Kong',
            'country_id' => '3',
        ));
        Institution::create(array(
            'name' => 'Hong Kong University of Science and Technology (Kowloon)',
            'country_id' => '3',
        ));

        //Japón
        Institution::create(array(
            'name' => 'Universidad de Tokyo',
            'country_id' => '4',
        ));

        //Rusia
        Institution::create(array(
            'name' => 'ITMO University',
            'country_id' => '5',
        ));

        //Cuba    
        Institution::create(array(
            'name' => 'Universidad de las Ciencias Informáticas',
            'country_id' => '6',
        ));
        Institution::create(array(
            'name' => 'Universidad de la Habana',
            'country_id' => '6',
        ));
    }
}
