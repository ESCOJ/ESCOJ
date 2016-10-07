<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\Source\Source;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Source::create(array(
            'name' => 'ESCOJ-Test 2016 - Miguel Mandujano',
        ));
        Source::create(array(
            'name' => 'ESCOJ-Test 2016 - Adrián Fernández',
        ));
    }
}
