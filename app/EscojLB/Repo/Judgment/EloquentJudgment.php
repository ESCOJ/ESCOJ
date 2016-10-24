<?php namespace EscojLB\Repo\Judgment;

use Illuminate\Database\Eloquent\Model;

class EloquentJudgment implements JudgmentInterface {

    protected $judgment;

    // Class expects an Eloquent model
    public function __construct(Model $judgment)
    {
        $this->judgment = $judgment;
    }

    /**
     * Create a new Judgment
     *
     * @param array  Data to create a new user object
     * @return User Object
     */
    public function create(array $data)
    {
        // Create the a user
        return $this->judgment->create(array(
            'submitted_at' => date('Y-m-d h:i:s \G\M\T'),
            'language' => $data['language'],
            'memory' => $data['memory'],
            'time' => $data['time'],
            'judgment' => $data['judgment'],
            'file_size' => $data['file_size'],
            'problem_id' => $data['problem_id'],
            'user_id' => $data['user_id'],
        ));

    }


    /**
     * Get all judgments as key-value array 
     *
     * @param  
     * @return array    Associative Array with all judgments
     */
    public function findAll()
    { 
      return $this->judgment->orderBy('submitted_at','desc')->get();
    }

}