<?php namespace EscojLB\Repo\Problem;

interface ProblemInterface {

    /**
     * Retrieve problem by id
     * regardless of status
     *
     * @param  int $id problem ID
     * @return stdObject object of problem information
     */
    public function byId($id);

    /**
     * Get paginated problems
     *
     * @param int $page Number of problems per page
     * @param int $limit Results per page
     * @param boolean $all Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page=1, $limit=10, $all=false);

   /* /**
     * Get single problem by URL
     *
     * @param string  URL slug of problem
     * @return object object of problem information
     */
    public function bySlug($slug);

   /**
     * Get problems by their tag
     *
     * @param string  URL slug of tag
     * @param int Number of problems per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($tag, $page=1, $limit=10);

    /**
     * Create a new Problem
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing Problem
     *
     * @param array  Data to update an problem
     * @return boolean
     */
    public function update(array $data);

}