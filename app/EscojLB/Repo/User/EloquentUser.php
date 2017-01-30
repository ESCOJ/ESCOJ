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
     * @param array   Provider has the name of the provider social network and the id  
     * @return User Object
     */
    public function create(array $data , $confirmation_code = null, $avatar ,array $provider = null)
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
            'submitted' => $data['submitted'],
            'accepted' => $data['accepted'],
            'avatar' => $avatar,
            'confirmation_code' => $confirmation_code,
            'provider' => $provider['provider'],
            'provider_id' => $provider['provider_id'],

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
     * Get a user by User Nickname
     *
     * @param  int $nickname       User nNckname
     * @return Object    User model object
     */
    public function findByNickname($nickname){
        return $this->user->where('nickname',$nickname)->first(['id']);
    }

    /**
     * Get a user by your provider name and provider ID
     * @param  string    $provider       social network provider  name
     * @param  int       $id       provider ID
     * @return Object    User model object
     */
    public function findByProvider($provider,$provider_id){
        return $this->user->where('provider', '=', $provider)->where('provider_id', '=', $provider_id)->first();
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

    /**
     * Get a user nickname by ID
     *
     * @param  int $id       User ID
     * @return string    user nickname
     */
    public function getNickname($id){
        return $this->user->find($id)->nickname;
    }   

    /*
     * Get paginated users
     *
     * @param int $limit Results per page
     * @return LengthAwarePaginator with the users to paginate
     */
    public function getAllPaginate($limit = 10){
        return $this->user->paginate($limit);
    }


    /**
     * Get filter paginated users
     *
     * @param int $limit Results per page
     * @param int  $nickname that is the filter to apply to the query.
     * @return LengthAwarePaginator with the users to paginate
     */
    public function getAllPaginateFilteredByNickname($limit = 10, $nickname){

        return $this->user->where('nickname', 'like', '%'. $nickname . '%')->paginate($limit);
    }

    /**
     * Update an existing User when the role change
     *
     * @param int $id      User ID
     * @param string       $role the value of the new role
     * @return boolean
     */
    public function changeRole($id, $role){
        $user = $this->findById($id);
        $user->role = $role;
        return $user->save();
    }

    /**
     * Get all User as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all User
     */
    public function getKeyValueAll($key,$value)
    { 
      return $this->user->pluck($value,$key);
    }

    /**
     * Get all User order points
     *
     * @return array    Associative Array with all User
     */
    public function getUsersOrderByPoints()
    {
        return $this->user->orderBy('points','desc')->paginate(5);
    }

    public function getUserByPoints($nickname){
        return $this->user->where('nickname',$nickname)->paginate(5);
    }
}