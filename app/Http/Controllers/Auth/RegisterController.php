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
        $this->middleware('guest', ['except' => ['profile','edit','update','getInstitutions']]);
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
        $countries = $this->country->getKeyValueAll('name','id');
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
        if ($request->has('github_id'))
        {

            $user = $this->create($request->all(),$request,$request->github_id);
            if ( ! $user )
            {
                flash('Error in your account registration.', 'danger');
            }
            else
            {
                $this->user->confirmationSuccess($user->id);
                Auth::login($user);
                flash('Thanks for signing up! start coding.', 'info');
            }

        }
        else
        {
            $confirmation_code = str_random(50);

            $user = $this->create($request->all(),$request,null,$confirmation_code);
            if ( ! $user )
            {
                flash('Error in your account registration.', 'danger');
            }
            else
            {    
                $user->sendConfirmAccountNotification($confirmation_code);

                flash('Thanks for signing up! Please check your email for confirm your account.', 'info');
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
    protected function create(array $data, Request $request, $github_id = null ,$confirmation_code = null)
    {
        $flag = false;
        if($request->file('avatar')){
            $image = $request->file('avatar');
            $avatar = $data['nickname'] . '.' . $image->extension();
            $flag = true;
        }
        else{
            $avatar = 'user_defaul.jpg';
        }
        $user = $this->user->create($data,$confirmation_code,$avatar,$github_id);  
        if( !is_null($user)  and  $flag){
            $image->storeAs('/images/user_avatar', $avatar, "uploads"); 
        }
        return $user;
    }

    public function confirm($confirmation_code)
    {

        if( ! $confirmation_code)
        {
            flash('Error in your account confirmation, not was given the confirmation code.', 'danger');
            return redirect('/');
        }

        $user = $this->user->whereConfirmationCode($confirmation_code);

        if ( ! $user )
        {

            flash('Error in your account confirmation, no user with this confirmation code.', 'danger');
            return redirect('/');
        }

        $this->user->confirmationSuccess($user->id);

        flash('You have successfully verified your account. Please sign in','info');

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
        $countries = $this->country->getKeyValueAll('name','id');
        $institutions = $this->institution->getInstitutionsKeyValueByCountry('name','id',$user->country_id);
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
                flash('Your account is disabled, Please check your email for confirm your account.', 'info');
            } 
            else
                flash('Error updating data', 'warning');
            return redirect('/');
        }

        if($flag)
            flash('Data updated successfully', 'success');
        else
            flash('Error updating data', 'warning');
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
            'nickname' => 'required|max:30|unique:users',
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

}
