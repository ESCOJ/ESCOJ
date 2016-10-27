<?php

namespace ESCOJ\Http\Controllers\Auth;

use Illuminate\Http\Request;
use ESCOJ\Http\Requests;
use ESCOJ\Http\Requests\UserUpdateRequest;
use ESCOJ\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Validator;
use File;
use Illuminate\Support\Facades\Auth;
use Mail;

use EscojLB\Repo\Country\CountryInterface;
use EscojLB\Repo\Institution\InstitutionInterface;
use EscojLB\Repo\User\UserInterface;




class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $country;
    protected $institution;
    protected $user;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
    public function __construct(CountryInterface $country,InstitutionInterface $institution,UserInterface $user)
    {
        $this->middleware('guest', ['except' => ['profile','edit','update','getInstitutions','users','changeUserRole']]);
        $this->middleware('auth', ['only' => ['profile','edit','update','users','changeUserRole']]);
        $this->middleware('admin', ['only' => ['users', 'changeUserRole']]);


        $this->country = $country;
        $this->institution = $institution;
        $this->user = $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $countries = $this->country->getKeyValueAll('id','name');
        return view('auth.register',['countries' => $countries]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();
        if ($request->has('provider'))
        {

            $provider['provider'] = $request->provider;
            $provider['provider_id'] = $request->provider_id;

            $user = $this->create($request->all(),$request,$provider);
            if ( ! $user )
            {
                flash('Error in your account registration.', 'danger')->important();
            }
            else
            {
                $this->user->confirmationSuccess($user->id);
                Auth::login($user);
                flash('Thanks for signing up! start coding.', 'info')->important();
            }

        }
        else
        {
            $confirmation_code = str_random(50);

            $user = $this->create($request->all(),$request,null,$confirmation_code);
            if ( ! $user )
            {
                flash('Error in your account registration.', 'danger')->important();
            }
            else
            {    
                $user->sendConfirmAccountNotification($confirmation_code);

                flash('Thanks for signing up! Please check your email for confirm your account.', 'info')->important();
            }
        } 
        return redirect('/');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, Request $request,array $provider = null,$confirmation_code = null)
    {
        $flag = false;
        if($request->file('avatar')){
            $image = $request->file('avatar');
            $avatar = $data['nickname'] . '.' . $image->extension();
            $flag = true;
        }
        else{
            $avatar = 'user_default.png';
        }
        $user = $this->user->create($data,$confirmation_code,$avatar,$provider);  
        if( !is_null($user)  and  $flag){
            $image->storeAs('/images/user_avatar', $avatar, "uploads"); 
        }
        return $user;
    }

    public function confirm($confirmation_code)
    {

        if( ! $confirmation_code)
        {
            flash('Error in your account confirmation, not was given the confirmation code.', 'danger')->important();
            return redirect('/');
        }

        $user = $this->user->whereConfirmationCode($confirmation_code);

        if ( ! $user )
        {

            flash('Error in your account confirmation, no user with this confirmation code.', 'danger')->important();
            return redirect('/');
        }

        $this->user->confirmationSuccess($user->id);

        flash('You have successfully verified your account. Please sign in','info')->important();

        return redirect('/');
    }

    /**
     * Display the user´s attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = $this->user->findById(Auth::user()->id);
        return view('user.profile',['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = $this->user->findById(Auth::user()->id);
        $countries = $this->country->getKeyValueAll('id','name');
        $institutions = $this->institution->getInstitutionsKeyValueByCountry('id','name',$user->country_id);
        return view('user.update',['user' => $user,'countries' => $countries, 'institutions' => $institutions]);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {   
        $pass = $flag = false;
        $email_prev = $this->user->getEmail(Auth::user()->id);

        if(!empty($request->password))
            $pass = true;

        if($request->file('avatar')){

            $image = $request->file('avatar');
            $avatar = $request['nickname'] . '.' . $image->extension();
            $avatar_prev = $this->user->getAvatar(Auth::user()->id);
            $flag = $this->user->update(Auth::user()->id,$request->all(),$pass,$avatar);

            if($flag){
                if(File::exists(public_path().'/images/user_avatar/'. $avatar_prev))
                    File::delete(public_path().'/images/user_avatar/'.$avatar_prev);
                $image->storeAs('/images/user_avatar/', $avatar, "uploads"); 
            }
        }
        else
            $flag = $this->user->update(Auth::user()->id,$request->all(),$pass);
        //If the email is changed
        if($email_prev != $request->email){

            $confirmation_code = str_random(50);

            if($flag and $this->user->updateEmailChange(Auth::user()->id,$confirmation_code)){
              
                $this->user->findById(Auth::user()->id)->sendConfirmAccountNotification($confirmation_code);
                $this->logout($request);
                flash('Your account is disabled, Please check your email for confirm your account.', 'info')->important();
            } 
            else
                flash('Error updating data', 'warning')->important();
            return redirect('/');
        }

        if($flag)
            flash('Data updated successfully', 'success')->important();
        else
            flash('Error updating data', 'warning')->important();
        return redirect('/contestant/profile');
    }

    /**
     * Get all intitutions for an incoming ajax request.
     *
     * @param  Request  $request
     * @param  var     $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getInstitutions(Request $request, $id){
        if($request->ajax()){
            $institutions=$this->institution->getInstitutionsByCountry($id);
            return response()->json($institutions);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'nickname' => 'required|max:30|alpha_dash|unique:users',
            'email' => 'required|email|max:60|confirmed|unique:users',
            'password' => 'required|min:6|confirmed',
            'country' => 'required',
            'institution' => 'required',
            'avatar' => 'image|max:35|dimensions:width=120,height=120',
            'terms_of_services' => 'accepted',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();

        $request->session()->regenerate();
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        if( $request->has('nickname') )
            $users = $this->user->getAllPaginateFilteredByNickname(5, $request->get('nickname'),false);   
        else
            $users = $this->user->getAllPaginate(5,false);

        $roles = [
                'admin' => 'Admin',
                'coach' => 'Coach',
                'problem_setter' => 'Problem Setter',
                'contestant' => 'Contestant',

            ];
        $request->flash();
        return view('user.admin.users',['users' => $users, 'roles' => $roles]);
    }

    /**
     * Change the user role.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeUserRole(Request $request)
    {
		if($this->user->changeRole($request->id, $request->role))
			flash('The user role of ' . $request->nickname . ' has been changed successfully to ' . $request->role . '.', 'success')->important();
		else
			flash('The user role of ' . $request->nickname . ' it has not been changed.', 'warning')->important();
		return back();

    }

}
