<?php namespace EscojLB\Repo\Contest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\DB;

use EscojLB\Repo\Organization\OrganizationInterface;

class EloquentContest implements ContestInterface {

    protected $contest;
    protected $organization;

    // Class expects an Eloquent model
    public function __construct(Model $contest, OrganizationInterface $organization)
    {
        $this->contest = $contest;
        $this->organization = $organization;
    }

    /**
     * Create a new contest
     *
     * @param array  Data to create a new object
     * @param int  ID of the user that add the contest
     * @return boolean id of the created contest or zero if fails
     */
    public function create(array $data, $user_id)
    {
        // Create the contest
        $contest = $this->contest->create(array(
            'name' => $data['name'],
            'organization_id' => $data['organization_id'],
            'penalization' => $data['penalization'],
            'frozen_time' => $data['frozen_time'],
            'access_type' => $data['access_type'],
            'description' => $data['description'],
            'start_date' => date_format(date_create($data['start_date']),"Y-m-d H:i:s"),
            'end_date' => date_format(date_create($data['end_date']),"Y-m-d H:i:s"),
            'added_by' => $user_id,
        ));

        if( $contest ){
        
            if(isset($data['offcontest'])){
                $contest->offcontest = $data['offcontest'];
                $contest->offcontest_penalization = $data['offcontest_penalization'];
                $contest->offcontest_start_date = date_format(date_create($data['offcontest_start_date']),"Y-m-d H:i:s");
                $contest->offcontest_end_date = date_format(date_create($data['offcontest_end_date']),"Y-m-d H:i:s");
                $contest->save();
            }

            if($data['access_type'] === 'private')
                $this->syncUsers($contest, $data['users']);

            $this->syncProblems($contest, $data['problems']);

            return $contest->id;
        }
        
        return 0;
    }

    /**
     * Update an existing Contest
     *
     * @param array  Data to update an Contest
     * @param  int $id       Contest ID
     * @return boolean 
     */
    public function update(array $data, $id)
    {
        $contest = $this->contest->find($id);
        $prev_access_type = $contest->access_type;

        $contest->name = $data['name'];
        $contest->organization_id = $data['organization_id'];
        $contest->penalization = $data['penalization'];
        $contest->frozen_time = $data['frozen_time'];
        $contest->access_type = $data['access_type'];
        $contest->description = $data['description'];
        $contest->start_date = date_format(date_create($data['start_date']),"Y-m-d H:i:s");
        $contest->end_date = date_format(date_create($data['end_date']),"Y-m-d H:i:s");

        if(isset($data['offcontest'])){
            $contest->offcontest = $data['offcontest'];
            $contest->offcontest_penalization = $data['offcontest_penalization'];
            $contest->offcontest_start_date = date_format(date_create($data['offcontest_start_date']),"Y-m-d H:i:s");
            $contest->offcontest_end_date = date_format(date_create($data['offcontest_end_date']),"Y-m-d H:i:s");
        }
        else if($contest->offcontest == '1'){
            $contest->offcontest = 0;
            $contest->offcontest_penalization = null;
            $contest->offcontest_start_date = null;
            $contest->offcontest_end_date = null;
        }

        $contest->save();

        if($data['access_type'] === 'private')
                $this->syncUsers($contest, $data['users']);
        else if($prev_access_type == 'private'){
            $this->syncUsers($contest, array());
        }

        $this->syncProblems($contest, $data['problems']);
        return true;
    }

    /**
     * Delete an existing Contest
     *
     * @param  int $id       Contest ID
     * @return boolean 
     */
    public function delete($id){
        return $this->contest->find($id)->delete();
    }

    /**
     * Sync Problems for contest
     *
     * @param \Illuminate\Database\Eloquent\Model  $contest
     * @param array  $problems
     * @return void
     */
    protected function syncProblems(Model $contest, array $problems)
    {
        // Assign set problems to contest

        $problemsIds = array();
        $i = 0;
        foreach($problems as $problem)
        {
            $problemsIds[$problem] = array('letter_id' => chr(65 + $i++) ) ;
        }

        // Assign set problems to problem
        $contest->problems()->sync($problemsIds);
    }

    /**
     * Sync Users for contest
     *
     * @param \Illuminate\Database\Eloquent\Model  $contest
     * @param array  $users
     * @return void
     */
    protected function syncUsers(Model $contest, array $users)
    {
        // Assign set users to contest
        $contest->users()->sync($users);
    }

    /**
     * Get paginated contests
     *
     * @param int $limit Results per page
     * @param int $no_admin indicates if contests will be filtered by added_by field.
     * @return LengthAwarePaginator with the contests to paginate
     */
    public function getAllPaginate($limit = 10, $no_admin = 0){
        if($no_admin)
            $this->contest = $this->contest->where('added_by', $no_admin);
        return $this->contest->with('organization')->paginate($limit);
    }

    /**
     * Get filter paginated contests
     *
     * @param int $limit Results per page
     * @param array  Data that contains the filters to apply to the query.
     * @param int $no_admin indicates if contests will be filtered by added_by field.
     * @return LengthAwarePaginator with the contests to paginate
     */
    public function getAllPaginateFiltered($limit = 10, array $data, $no_admin = 0){

        if( isset($data['organization']) and $data['organization'] )
            $queryBuilder = $this->filterByOrganization($data['organization'])->getQuery();

        if( ! isset($queryBuilder) )
                $queryBuilder = $this->contest->with('organization');

        if( isset($data['time']) and $data['time'])
            $queryBuilder = $this->filterByTime($queryBuilder,$data['time']);

        if( !empty($data['name']) )
            $queryBuilder = $this->filterByName($queryBuilder,$data['name']);

        if($no_admin)
            $queryBuilder->where('added_by', $no_admin);

        return $queryBuilder->paginate($limit);
    }

    /**
     * Get all problems order by lletter id
     *
     * @param int $contest_id Id of contest.
     * @return Collection with all problems of a contest.
     */
    public function getAllProblemsOrderByLetterId($contest_id){
        $contest = $this->findById($contest_id);
        return $contest->problems()->orderBy('letter_id')->pluck('letter_id','problem_id');
    }

    /**
     * Get all Users with eager loading judgments of a contest
     *
     * @param array $contest_data indicates if judgments will be filtered by contest_id field and if the contest is current appply the logic to frozen time.
     * @return Collection with all Users of a contest.
     */
    public function getAllUsersWithJudgmentsByContest($contest_data){
        $contest = $this->findById($contest_data['contest_id']);
        return $contest->users()->with('country')->with(['judgments' => function($query) use ($contest_data) {
                $query = $query->where('contest_id', $contest_data['contest_id']);

                if($contest_data['status'] == 'current')
                    $query->where('submitted_at', '<=' , $contest_data['limit_date_time']);

            }])->get(['users.id','nickname','avatar','country_id']);
    }


    /**
     * Get a Contest by Contest ID
     *
     * @param  int $id       Contest ID
     * @return Object    Contest model object
     */
    public function findById($id){
        return $this->contest->findOrFail($id);
    }

    /**
     * Retrieve ids of selected problems for contest
     *
     * @param \Illuminate\Database\Eloquent\Model  $contest
     * @return array  with all ids of the selected problems
     */
    public function getSelectedProblems(Model $contest){
        return $contest->problems()->pluck('problems.id')->toArray();
    }

    /**
     * Retrieve ids of selected users for contest
     *
     * @param \Illuminate\Database\Eloquent\Model  $contest
     * @return array  with all ids of the selected users
     */
    public function getSelectedUsers(Model $contest){
        return $contest->users()->pluck('users.id')->toArray();
    }

    /**
     * Filter by time (future-now-past)
     *
     * @param \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param string  $time
     * @return Builder
     */
    protected function filterByTime(Builder $queryBuilder, $time)
    {
        $now = date_format(date_create(),"Y-m-d H:i:s");
        
        switch ($time) {
            case 'future':
                    return $queryBuilder->where('start_date', '>', $now);
                break;

            case 'current':
                    return $queryBuilder->where('start_date', '<=', $now)->where('end_date', '>', $now);
                break; 
            case 'past':
                    return $queryBuilder->where('end_date', '<', $now);
                break;                   
        }
    }

    /**
     * Filter by Name 
     *
     * @param \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param string  $name
     * @return Builder
     */
    protected function filterByName(Builder $queryBuilder, $name)
    {
        return  $queryBuilder->where(function ($query) use ($name) {
                    $query->where('name', 'like', '%'. $name . '%')
                          ->orWhere('contests.id', 'like', '%'. $name . '%');
                });
    }

    /**
     * Filter by Organization
     *
     * @param string  $organization
     * @return Builder
     */
    protected function filterByOrganization($organization)
    {
        return  $this->organization->findById($organization)->contests()->with('organization');
    }

    /**
     * Retrieve the penalization time and start date.
     *
     * @param int $id    Contest ID
     * @return Collection 
     */
    public function getPenalizationTimeAndStartDate($id){
        return $this->contest->find($id,['penalization','start_date','id']);
    }

    /**
     * Add a user to a contest.
     *
     * @param int $contest_id Id of contest.
     * @param int $user_id Id of user.
     * @return Collection with all problems of a contest.
     */
    public function attach($contest_id, $user_id){
        $contest = $this->findById($contest_id);
        if(!$contest->users->contains($user_id))
            $contest->users()->attach($user_id);
    }

}