<?php namespace EscojLB\Repo\Problem;

interface ProblemInterface {

    /**
     * Create a new Problem
     *
     * @param array  Data to create a new object
     * @param int  ID of the user that add the problem
     * @return boolean
     */
    public function create(array $data, $user_id);

    /**
     * Update an existing Problem
     *
     * @param array  Data to update an problem
     * @return boolean
     */
    public function update(array $data);

}