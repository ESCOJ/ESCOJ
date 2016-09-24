<?php namespace EscojLB\Repo\User;

interface UserInterface {

    /**
     * Retrieve user by id
     * regardless of status
     *
     * @param  int $id user ID
     * @return stdObject object of user information
     */
    public function byId($id);

    /**
     * Get paginated users
     *
     * @param int $page Number of users per page
     * @param int $limit Results per page
     * @param boolean $all Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page=1, $limit=10, $all=false);

   /* /**
     * Get single user by URL
     *
     * @param string  URL slug of user
     * @return object object of user information
     */
    public function bySlug($slug);

   /**
     * Get user by their tag
     *
     * @param string  URL slug of tag
     * @param int Number of users per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($tag, $page=1, $limit=10);

    /**
     * Create a new user
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing user
     *
     * @param array  Data to update an user
     * @return boolean
     */
    public function update(array $data);

}