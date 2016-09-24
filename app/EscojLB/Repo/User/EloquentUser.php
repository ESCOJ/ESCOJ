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

}