<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\Tag\Tag;
class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	Tag::create(array(
            'name' => 'Ad-hoc (AH)',
        ));
        Tag::create(array(
            'name' => 'Arithmetic-Algebra (AA)',
        ));
        Tag::create(array(
            'name' => 'Brute Force (BF)',
        ));
        Tag::create(array(
            'name' => 'Combination (CO)',
        ));
        Tag::create(array(
            'name' => 'Data Structures (DS)',
        ));
        Tag::create(array(
            'name' => 'Dynamic Programming (DP)',
        ));
        Tag::create(array(
            'name' => 'Game Theory (GA)',
        ));
        Tag::create(array(
            'name' => 'General Geometry (GE)',
        ));
        Tag::create(array(
            'name' => 'Graph Theory (GT)',
        ));
        Tag::create(array(
            'name' => 'Greedy (GR)',
        ));
        Tag::create(array(
            'name' => 'Set-Number Theory (NT)',
        ));
        Tag::create(array(
            'name' => 'Sorting-Searching (SS)',
        ));
        Tag::create(array(
            'name' => 'Strings (ST)',
        ));
    }
}
