<?php namespace EscojLB\Repo\User;

use Illuminate\Database\Eloquent\Model;

class EloquentUser implements UserInterface {

    protected $user;

    // Class expects an Eloquent model
    public function __construct(Model $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new User
     *
     * @param array  Data to create a new user object
     * @param string  $avatar the name of the avatar image
     * @param string  $confirmation_code the value of the confirmation code
     * @param string  $github_id the value of the github_id
     * @return User Object
     */
    public function create(array $data , $confirmation_code = null, $avatar ,$github_id = null)
    {
        // Create the a user
        return $this->user->create(array(
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'register_date' => date("Y/m/d"),
            'institution_id' => $data['institution'],
            'country_id' => $data['country'],
            'avatar' => $avatar,
            'confirmation_code' => $confirmation_code,
            'github_id' => $github_id,
        ));

    }

    /**
     * Get a user by User ID
     *
     * @param  int $id       User ID
     * @return Object    User model object
     */
    public function findById($id){
        return $this->user->find($id);
    }

    /**
     * Get a user by your Github ID
     *
     * @param  int $id       Github ID
     * @return Object    User model object
     */
    public function findByGithubId($id){
        return $this->user->where('github_id', '=', $id)->first();
    }

    /**
     * Set the attributes that indicate that the account is confirmed
     *
     * @param  int $id       User ID
     * @return bool    value of the save method
     */
    public function confirmationSuccess($id){
        $user = $this->findById($id);
        $user->confirmed = 1;
        $user->confirmation_code = null;
        return $user->save();
    }

    /**
     * Update an existing User
     *
     * @param int $id      User ID
     * @param array        Data to update an User
     * @param bool         $withPass to indicate whether the password will be update
     * @param string       $Avatar or null to indicate whether the avatar will be update
     * @return boolean
     */
    public function update($id, array $data, $withPass, $Avatar = null)
    {
        $user = $this->findById($id);
        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        if($withPass)
            $user->password = bcrypt($data['password']);
        if(!is_null($Avatar))
            $user->avatar = $Avatar;
        $user->country_id = $data['country'];
        $user->institution_id = $data['institution'];
        return $user->save();
    }

     /**
     * Update an existing User when the email change
     *
     * @param int $id      User ID
     * @param string       $confirmation_code the value of the confirmation code
     * @return boolean
     */
    public function updateEmailChange($id, $confirmation_code){
        $user = $this->findById($id);
        $user->confirmed = 0;
        $user->confirmation_code = $confirmation_code;
        return $user->save();
    }


     /**
     * Retrieve the avatar name by User ID
     *
     * @param  int $id       User ID
     * @return string    avatar name
     */
    public function getAvatar($id){
        $user = $this->findById($id);
        return $user->avatar;
    }

    /**
     * Retrieve a user by a given conformation code
     *
     * @param  string $confirmation_code    attribute confirmation code
     * @return Object    User model object
     */
    public function whereConfirmationCode($confirmation_code){
        return $this->user->where('confirmation_code','=',$confirmation_code)->first();
    }

    /**
     * Get a user email by User ID
     *
     * @param  int $id       User ID
     * @return string    user email
     */
    public function getEmail($id){
        return $this->user->find($id)->email;
    }

}