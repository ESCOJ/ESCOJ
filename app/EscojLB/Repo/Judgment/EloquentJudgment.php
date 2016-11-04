<?php namespace EscojLB\Repo\Judgment;

use Illuminate\Database\Eloquent\Model;
use EscojLB\Repo\User\UserInterface;
use Illuminate\Support\Facades\DB;

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
            'submitted_at' => date('Y-m-d h:i:s'),
            'language' => $data['language'],
            'memory' => (int)$data['memory'],
            'time' => (int)$data['time'],
            'judgment' => $data['judgment'],
            'file_size' => (int)$data['file_size'],
            'problem_id' => (int)$data['problem_id'],
            'user_id' => (int)$data['user_id'],
        ));

    }

    /**
     * Get all judgments as key-value array 
     *
     * @param  
     * @return array    Associative Array with all judgments
     */
    public function getAllOrderedBySubmitted($limit = 10)
    { 
      return $this->judgment->orderBy('id','desc')->paginate($limit);
      
    }

    /**
     * Get filter paginated problems
     *
     * @param int $limit Results per page
     * @param array  Data that contains the filters to apply to the query.
     * @return LengthAwarePaginator with the problems to paginate
     */
    public function getAllPaginateFiltered($limit = 10, array $data, $enable = true){
        return $this->judgment->orderBy('id','desc')->paginate($limit);
    }

}