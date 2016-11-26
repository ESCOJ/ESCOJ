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
    	$prob =  Problem::create(array(
			    'name' => 'A +B Problem',
			    'source_id' => '1',
			    'points' => '50',
			    'description' => 'For this problem you must calculate <strong>A + B</strong>, numbers given in the input. ',
			    'input_specification' => 'The only line of input contain two space separated integers <strong>A, B (0 <= A, B <= 10).</strong> ',
			    'output_specification' => 'The only line of output should contain one integer: the sum of <strong>A</strong> and <strong>B</strong>. ',
			    'sample_input' => '1 2',
			    'sample_output' => '3',
			    'hints' => 'no se weno si se pero no te wa decir',
			    'added_by' => '1',
			    'enable' => '1',
			    'multidata' => '1',
			    'dataset' => 1,
			));

		$prob->tags()->sync([1 => ['level' => 1],2 => ['level' => 2]]);
		$prob->languages()->sync([1,2]);

    	for ($i=2; $i <= 4 ; $i++) { 
    		$prob =  Problem::create(array(
			    'name' => 'Problema ' . $i,
			    'source_id' => '1',
			    'points' => '50',
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
