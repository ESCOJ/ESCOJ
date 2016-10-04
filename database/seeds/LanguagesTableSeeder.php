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
        ));
        Language::create(array(
            'name' => 'C++',
        ));
        Language::create(array(
            'name' => 'Java',
        ));
        Language::create(array(
            'name' => 'Python',
        ));
    }
}




