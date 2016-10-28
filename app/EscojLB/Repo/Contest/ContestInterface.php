<?php namespace EscojLB\Repo\Contest;
use Illuminate\Database\Eloquent\Model;

interface ContestInterface {

    /**
     * Create a new Contest
     *
     * @param array  Data to create a new object
     * @param int  ID of the user that add the Contest
     * @return boolean id of the created Contest or zero if fails
     */
    public function create(array $data, $user_id);

    /**
     * Update an existing Contest
     *
     * @param array  Data to update an Contest
     * @param  int $id       Contest ID
     * @return boolean 
     */
    public function update(array $data, $id);

    /**
     * Delete an existing Contest
     *
     * @param  int $id       Contest ID
     * @return boolean 
     */
    public function delete($id);

     /**
     * Get paginated contests
     *
     * @param int $limit Results per page
     * @param int $no_admin indicates if contests will be filtered by added_by field.
     * @return LengthAwarePaginator with the contests to paginate
     */
    public function getAllPaginate($limit = 10, $no_admin = 0);

    /**
     * Get filter paginated contests
     *
     * @param int $limit Results per page
     * @param array  Data that contains the filters to apply to the query.
     * @param int $no_admin indicates if contests will be filtered by added_by field.
     * @return LengthAwarePaginator with the contests to paginate
     */
    public function getAllPaginateFiltered($limit = 10, array $data, $no_admin = 0);

    /**
     * Get a Contest by Contest ID
     *
     * @param  int $id       Contest ID
     * @return Object    Contest model object
     */
    public function findById($id);

    /**
     * Retrieve ids of selected problems for contest
     *
     * @param \Illuminate\Database\Eloquent\Model  $contest
     * @return array  with all ids of the selected problems
     */
    public function getSelectedProblems(Model $contest);

    /**
     * Retrieve ids of selected users for contest
     *
     * @param \Illuminate\Database\Eloquent\Model  $contest
     * @return array  with all ids of the selected users
     */
    public function getSelectedUsers(Model $contest);

}