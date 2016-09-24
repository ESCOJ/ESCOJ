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

}
