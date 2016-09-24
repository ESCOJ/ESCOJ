<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use ESCOJ\User;
use ESCOJ\Country;
use ESCOJ\Institution;
use ESCOJ\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     /**
     * Display the user´s attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(){
    	$user = User::find(Auth::user()->id);
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

    	$user = User::find(Auth::user()->id);
    	$countries = Country::pluck('name','id');
        //return view('auth.register',compact('countries'));
        return view('user.update',['user' => $user,'countries' => $countries]);

    }


    public function getInstitutions(Request $request, $id){
        if($request->ajax()){
            $institutions = Institution::institutions($id);
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

