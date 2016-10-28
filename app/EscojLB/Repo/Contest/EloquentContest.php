<?php namespace EscojLB\Repo\Contest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class EloquentContest implements ContestInterface {

    protected $contest;

    // Class expects an Eloquent model
    public function __construct(Model $contest)
    {
        $this->contest = $contest;

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
        $contest->problems()->sync($problems);
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
        $contests = $this->contest->getQuery();
        if($no_admin)
             $contests->where('added_by', $no_admin);
        return $contests->paginate($limit);
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
        $contests = $this->contest->getQuery();
        if($no_admin)
            $contests->where('added_by', $no_admin);

        return $contests->where(function ($query) use ($data) {
                                    $query->where('name', 'like', '%'. $data['name'] . '%')
                                          ->orWhere('id', 'like', '%'. $data['name'] . '%');
                                })->paginate($limit);
    }

    /**
     * Get a Contest by Contest ID
     *
     * @param  int $id       Contest ID
     * @return Object    Contest model object
     */
    public function findById($id){
        return $this->contest->find($id);
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

}