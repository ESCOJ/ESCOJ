<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\Problem\Problem;

class ProblemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 10 ; $i++) { 
    		$prob =  Problem::create(array(
			    'name' => 'Problema ' . $i,
			    'source_id' => '1',
			    'points' => '50' .$i,
			    'description' => 'Este problema si que rifa machin <br> <strong>hola que hace</strong><br><p>ferras ya estuvo</p>',
			    'input_specification' => 'mete lo que sea',
			    'output_specification' => 'saldra lo que sea',
			    'sample_input' => '1 2 3 fibonanci',
			    'sample_output' => 'fibonanci c',
			    'hints' => 'no se weno si se pero no te wa decir',
			    'added_by' => '1',
			    'enable' => '1',
			    'multidata' => '1',
			));
			$prob->tags()->sync([1 => ['level' => 1],2 => ['level' => 2]]);
			$prob->languages()->sync([1,2]);
    	}


    }
}
