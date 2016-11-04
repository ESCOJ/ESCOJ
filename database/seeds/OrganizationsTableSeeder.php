<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\Organization\Organization;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::create(array(
            'name' => 'Club de Algoritmia ESCOM',
        ));
        Organization::create(array(
            'name' => 'ESCOJ-Test 2016 organization',
        ));

    }
}
