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
     *
     * @return User Object
     */
    public function create(array $data , $avatar)
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
     * Retrieve the avatar name by User ID
     *
     * @param  int $id       User ID
     * @return string    avatar name
     */
    public function getAvatar($id){
        $user = $this->findById($id);
        return $user->avatar;
    }

}