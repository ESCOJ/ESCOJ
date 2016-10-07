<?php namespace EscojLB\Repo\Problem;

use Illuminate\Database\Eloquent\Model;

class EloquentProblem implements ProblemInterface {

    protected $problem;

    // Class expects an Eloquent model
    public function __construct(Model $problem)
    {
        $this->problem = $problem;
    }

    /**
     * Create a new Problem
     *
     * @param array  Data to create a new object
     * @param int  ID of the user that add the problem
     * @return boolean
     */
    public function create(array $data, $user_id)
    {
        // Create the problem
        $problem = $this->problem->create(array(
            'name' => $data['name'],
            'source_id' => $data['source'],
            'description' => $data['description'],
            'input_specification' => $data['input_specification'],
            'output_specification' => $data['output_specification'],
            'sample_input' => $data['sample_input'],
            'sample_output' => $data['sample_output'],
            'hints' => $data['hints'],
            'added_by' => $user_id,
        ));

        if( ! $problem )
            return false;
        return true;
    }

    /**
     * Update an existing Problem
     *
     * @param array  Data to update an Problem
     * @return boolean
     */
    public function update(array $data)
    {
        $problem = $this->problem->find($data['id']);
        $problem->name = $data['name'];
        $problem->author = $data['author'];
        $problem->tlpc = $data['tlpc'];
        $problem->ttl = $data['ttl'];
        $problem->ml = $data['ml'];
        $problem->sl = $data['sl'];
        $problem->description = $data['description'];
        $problem->input_specification = $data['input_specification'];
        $problem->output_specification = $data['output_specification'];
        $problem->sample_input = $data['sample_input'];
        $problem->sample_output = $data['sample_output'];
        $problem->hints = $data['hints'];
        $problem->points = $data['points'];
        $problem->status = $data['status'];
        $problem->save();

        return true;
    }



}
