<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use EscojLB\Repo\User\UserInterface;
use EscojLB\Repo\Ranks\RanksInterface;
use ESCOJ\Http\Requests;

class RanksController extends Controller
{
	protected $ranks;
    protected $user;

    public function __construct(UserInterface $user,RanksInterface $ranks){
    	$this->ranks = $ranks;
    	$this->user = $user;
    }

    /**
     * Display a listing of the users ordered by points.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        //dd($request['name']);
        if($request->has('name'))
            $users = $this->user->getUserByPoints($request['name']);
            
        else 
            $users = $this->user->getUsersOrderByPoints();

        $request->flash();
    	//dd($users);
        return view('ranks.index',['users' => $users]);
    }
}
