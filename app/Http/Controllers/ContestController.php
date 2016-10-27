<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;

use ESCOJ\Http\Requests;
use EscojLB\Repo\Organization\OrganizationInterface;
use EscojLB\Repo\Problem\ProblemInterface;
use EscojLB\Repo\User\UserInterface;


class ContestController extends Controller
{
    //
    protected $problem;
    protected $user;
    protected $organization;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationInterface $organization, ProblemInterface $problem, UserInterface $user){

        /*$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('adminOrProblemSetter', ['except' => ['index', 'show']]);
        $this->middleware('problemAuthorize', ['except' => ['index', 'create', 'store', 'show','inputToSelectTags', 'problemSetterProblems']]);*/
        $this->organization = $organization;
        $this->problem = $problem;
        $this->user = $user;

    }

    /**
     * Show the form for creating a new contest.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = $this->organization->getKeyValueAll('id','name');

        return view('contest.add',['organizations' => $organizations]);
    }

    /**
     * Store a newly created contest in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	dd($request->all());
        /*if($request->ajax()){
            if($request->action === Constants::CEATE_contest){
                $contest_id = $this->contest->create($request->all(),Auth::user()->id);
                if($contest_id){
                    $url = '/contest/limits/'.$contest_id;

                    return response()->json([
                        'message' => 'The contest has been created successfully.',
                        'redirect' => $url
                    ]);
                }
            }
        }*/
    }

}
