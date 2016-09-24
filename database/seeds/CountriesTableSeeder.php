<?php

use Illuminate\Database\Seeder;
use ESCOJ\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Country::create(array(
            'name' => 'Mexico',
        ));

        Country::create(array(
            'name' => 'Estados Unidos',
        ));
        Country::create(array(
            'name' => 'China',
        ));
        Country::create(array(
            'name' => 'Japon',
        ));
        Country::create(array(
            'name' => 'Rusia',
        ));

        //Model::unguard();
    }
}
