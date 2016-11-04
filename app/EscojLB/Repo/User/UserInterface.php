<?php namespace EscojLB\Repo\User;

interface UserInterface {

   /**
     * Create a new User
     *
     * @param array  Data to create a new user object
     * @param string  $avatar the name of the avatar image
     * @param string  $confirmation_code the value of the confirmation code
     * @param array   Provider has the name of the provider social network and the id  
     * @return User Object
     */
    public function create(array $data , $confirmation_code = null, $avatar ,array $provider = null);
    /**
     * Get a user by User ID
     *
     * @param  int $id       User ID
     * @return Object    User model object
     */
    public function findById($id);

    /**
     * Get a user by your provider name and provider ID
     * @param  string    $provider       social network provider  name
     * @param  int       $id       Github ID
     * @return Object    User model object
     */
    public function findByProvider($provider,$provider_id);

    /**
     * Set the attributes that indicate that the account is confirmed
     *
     * @param  int $id       User ID
     * @return bool    value of the save method
     */
    public function confirmationSuccess($id);

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
     * Update an existing User when the email change
     *
     * @param int $id      User ID
     * @param string       $confirmation_code the value of the confirmation code
     * @return boolean
     */
    public function updateEmailChange($id, $confirmation_code);

     /**
     * Retrieve the avatar name by User ID
     *
     * @param  int $id       User ID
     * @return string    avatar name
     */
    public function getAvatar($id);

    /**
     * Retrieve a user by a given conformation code
     *
     * @param  string $confirmation_code    attribute confirmation code
     * @return Object    User model object
     */
    public function whereConfirmationCode($confirmation_code);

    /**
     * Get a user email by User ID
     *
     * @param  int $id       User ID
     * @return string    user email
     */
    public function getEmail($id);

    /**
     * Get a user nickname by ID
     *
     * @param  int $id       User ID
     * @return string    user nickname
     */
    public function getNickname($id);


}
