<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use ESCOJ\User;
use ESCOJ\Http\Requests;
use Illuminate\Support\Facades\Auth;

use EscojLB\Repo\Country\CountryInterface;
use EscojLB\Repo\Institution\InstitutionInterface;
use EscojLB\Repo\User\UserInterface;

class UserController extends Controller
{

   
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
        $this->country = $country;
        $this->institution = $institution;
        $this->user = $user;
    }

     /**
     * Display the user´s attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(){
    	//$user = User::find(Auth::user()->id);
        $user = $this->user->findById(Auth::user()->id);
    	//dd($user->institution->name);
    	return view('user.profile',['user' => $user]);
    }

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(){

        $user = $this->user->findById(Auth::user()->id);
        $countries = $this->country->getKeyValueAll('name','id');
        return view('user.update',['user' => $user,'countries' => $countries]);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        dd($request);
        $this->movie->fill($request->all());
        $this->movie->save();

        Session::flash('message','Pelicula Editada Correctamente');
        return Redirect::to('/pelicula');

        $image = $request->file('avatar');
        $name = $data['nickname']. time() . '.' . $image->extension();
        $image->storeAs('/images/user_avatar', $name, "uploads"); 
        
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'register_date' => date("Y/m/d"),
            'institution_id' => $data['institution'],
            'country_id' => $data['country'],
            'avatar' => $name,
        ]);
    }
}

