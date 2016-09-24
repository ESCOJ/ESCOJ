<?php

namespace ESCOJ\Http\Controllers\Auth;

use Illuminate\Http\Request;
use ESCOJ\Http\Requests;
use ESCOJ\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Validator;

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
        $this->middleware('guest');
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

        $this->guard()->login($this->create($request->all(),$request));

        return redirect($this->redirectPath());
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
            'email' => 'required|email|max:60|unique:users',
            'password' => 'required|min:6|confirmed',
            'country' => 'required',
            'institution' => 'required',
            'avatar' => 'image|max:35|dimensions:width=120,height=120',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data,Request $request )
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
        $user = $this->user->create($data,$avatar);  
        if( !is_null($user)  and  $flag){
            $image->storeAs('/images/user_avatar', $avatar, "uploads"); 
        }
        return $user;
    }
}
