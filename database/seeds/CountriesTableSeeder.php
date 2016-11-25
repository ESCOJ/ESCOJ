<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\Country\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Get all of the countries
        $countries = json_decode(file_get_contents(storage_path().'/countries.json'), true);

        foreach ($countries as $countryId => $country){
            Country::create(array(
                //'id' => $countryId,
                'name' => $country['name'],
                'full_name' => ((isset($country['full_name'])) ? $country['full_name'] : null),
                'flag' =>((isset($country['flag'])) ? $country['flag'] : null),
            ));
        }

    }

}
