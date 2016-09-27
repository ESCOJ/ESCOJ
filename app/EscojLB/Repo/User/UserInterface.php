<?php namespace EscojLB\Repo\User;

interface UserInterface {

    /**
     * Create a new User
     *
     * @param array  Data to create a new user object
     * @param string  $avatar the name of the avatar image
     *
     * @return User Object
     */
    public function create(array $data , $avatar);

    /**
     * Get a user by User ID
     *
     * @param  int $id       User ID
     * @return Object    User model object
     */
    public function findById($id);

     /**
     * Update an existing User
     *
     * @param int $id      User ID
     * @param array        Data to update an User
     * @param bool         $withPass to indicate whether the password will be update
     * @param string       $Avatar or null to indicate whether the avatar will be update
     * @return boolean
     */
    public function update($id, array $data, $withPass, $Avatar = null);

     /**
     * Retrieve the avatar name by User ID
     *
     * @param  int $id       User ID
     * @return string    avatar name
     */
    public function getAvatar($id);

}
