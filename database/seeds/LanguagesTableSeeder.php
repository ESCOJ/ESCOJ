<?php

use EscojLB\Repo\language\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Language::create(array(
            'name' => 'C',
            'tlpc_multiplier' => 1.0,
            'ttl_multiplier' => 1.0,
            'ml_multiplier' => 1.0,
            'sl_multiplier' => 1.0,
        ));
        Language::create(array(
            'name' => 'C++',
            'tlpc_multiplier' => 1.0,
            'ttl_multiplier' => 1.0,
            'ml_multiplier' => 1.0,
            'sl_multiplier' => 1.0,
        ));
        Language::create(array(
            'name' => 'Java',
            'tlpc_multiplier' => 3.0,
            'ttl_multiplier' => 3.0,
            'ml_multiplier' => 6.0,
            'sl_multiplier' => 1.0,
        ));
        Language::create(array(
            'name' => 'Python',
            'tlpc_multiplier' => 2.0,
            'ttl_multiplier' => 2.0,
            'ml_multiplier' => 3.0,
            'sl_multiplier' => 1.0,
        ));
    }
}




