<?php namespace EscojLB\Repo\Judgment;

use Illuminate\Database\Eloquent\Model;
use EscojLB\Repo\User\UserInterface;
use Illuminate\Support\Facades\DB;

class EloquentJudgment implements JudgmentInterface {

    protected $judgment;
    protected $user;


    // Class expects an Eloquent model
    public function __construct(Model $judgment, UserInterface $user)
    {
        $this->judgment = $judgment;
        $this->user = $user;
    }

    /**
     * Create a new Judgment
     *
     * @param array  Data to create a new user object
     * @param int  $contest_id if this is not null idicates wheter a judgment belongs to a contest and the id is given.
     * @return User Object
     */
    public function create(array $data, $contest_id = null){

        $bool_contest = (!is_null($contest_id))? 1 : 0;

        return $this->judgment->create(array(
            'submitted_at' => date('Y-m-d H:i:s'),
            'language' => $data['language'],
            'memory' => (int)$data['memory'],
            'time' => (int)$data['time'],
            'judgment' => $data['judgment'],
            'file_size' => (int)$data['file_size'],
            'problem_id' => (int)$data['problem_id'],
            'user_id' => (int)$data['user_id'],
            'contest' => $bool_contest,
            'contest_id' => $contest_id,
        ));

    }

     /**
     * Get paginated judgments
     *
     * @param int $limit Results per page
     * @param int $by_contest indicates if judgments will be filtered by contest_id field.
     * @return LengthAwarePaginator with the judgments to paginate
     */
    public function getAllPaginate($limit = 10, $by_contest = 0){
        if($by_contest)
            $this->judgment = $this->judgment->where('contest_id', $by_contest);
        else
            $this->judgment = $this->judgment->where('contest', 0);
        return $this->judgment->orderBy('id','desc')->with('user')->paginate($limit);
    }

    /**
     * Get filter paginated judgments
     *
     * @param int $limit Results per page
     * @param array  Data that contains the filters to apply to the query.
     * @param int $by_contest indicates if judgments will be filtered by contest_id field.
     * @return LengthAwarePaginator with the judgments to paginate
     */
    public function getAllPaginateFiltered($limit = 10, array $data, $by_contest = 0){
        if($by_contest)
            $queryBuilder = $this->judgment->where('contest_id', $by_contest);
        else
            $queryBuilder = $this->judgment->where('contest', 0);

        if( isset($data['user']) and $data['user'] ){
            $user = $this->user->findByNickname($data['user']);
            if($user)
                $queryBuilder = $queryBuilder->where('user_id',$user->id);
            else
                $queryBuilder = $queryBuilder->where('user_id','0');
        }

        if( isset($data['problem']) and $data['problem'] )
            $queryBuilder = $queryBuilder->where('problem_id',$data['problem']);

        if( isset($data['language']) and $data['language'] )
            $queryBuilder = $queryBuilder->where('language',$data['language']);

        return $queryBuilder->orderBy('id','desc')->with('user')->paginate($limit);
    }

}