<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;

use ESCOJ\Http\Requests\ContestDescriptionRequest;
use EscojLB\Repo\Organization\OrganizationInterface;
use EscojLB\Repo\Contest\ContestInterface;
use EscojLB\Repo\User\UserInterface;
use EscojLB\Repo\Problem\ProblemInterface;

use Auth;

class ContestController extends Controller
{
    //
    protected $contest;
    protected $user;
    protected $organization;
    protected $problem;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationInterface $organization, ContestInterface $contest,
    						    UserInterface $user , ProblemInterface $problem){

        /*$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('adminOrcontestSetter', ['except' => ['index', 'show']]);
        $this->middleware('contestAuthorize', ['except' => ['index', 'create', 'store', 'show','inputToSelectproblems', 'contestSettercontests']]);*/
        $this->organization = $organization;
        $this->contest = $contest;
        $this->user = $user;
        $this->problem = $problem;


    }

    /**
     * Show the form for creating a new contest.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = $this->organization->getKeyValueAll('id','name');
        $problems = $this->inputToSelectProblems();
        $users = $this->user->getKeyValueAll('id','nickname');
        return view('contest.add',['organizations' => $organizations, 'problems' => $problems, 'users' => $users]);
    }

    /**
     * Store a newly created contest in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestDescriptionRequest $request)
    { 
        $contest_id = $this->contest->create($request->all(),Auth::user()->id);
        flash('The contest has been created successfully','success')->important();
        return redirect()->route('contest.contests');
    }

     /**
     * Show the form for eding a existing contest.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contest = $this->contest->findById($id);

 		$organizations = $this->organization->getKeyValueAll('id','name');
        $problems = $this->inputToSelectProblems();
        $users = $this->user->getKeyValueAll('id','nickname');

        $problems_selected = $this->contest->getSelectedProblems($contest);
        $users_selected = $this->contest->getSelectedUsers($contest);

        return view('contest.update',['contest' => $contest, 'organizations' => $organizations, 'problems' => $problems, 'users' => $users, 'problems_selected' => $problems_selected, 'users_selected' => $users_selected]);
    }

    /**
     * Update a existing contest.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ContestDescriptionRequest $request ,$id)
    {
        if($this->contest->update($request->all(),$id)){
        	flash('The contest has been updated successfully.','success')->important();
        	return redirect()->route('contest.contests');
        }

        flash('The contest could not be deleted.','warning')->important();
        return redirect()->route('contest.contests');
    }

    /**
     * Remove the specified contest from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if($this->contest->delete($id))
        	flash('The contest has been removed successfully.','success')->important();
        else
            flash('The contest could not be removed.','warning')->important();
        return back();
    }

     /**
     * Display a listing of the Contests.
     *
     * @return \Illuminate\Http\Response
     */
    public function contests(Request $request)
    {
        $id = (Auth::user()->role != 'admin')? Auth::user()->id : 0;
        if( $request->has('name') )
            $contests = $this->contest->getAllPaginateFiltered(5, $request->all(),$id);   
        else
            $contests = $this->contest->getAllPaginate(5,$id);

        $request->flash();
        return view('contest.admin.index',['contests' => $contests]);
    }

     /**
     * Generate the input to the Problems selection.
     *
     * @return \Illuminate\Http\Response
     */
    public function inputToSelectProblems()
    {
        $problems = $this->problem->getKeyValueAllOrderBy('id','name','id');
        foreach ($problems as $problem_id => $problem_name) {
        	$problems[$problem_id] = $problem_id . ' - ' . $problem_name;
        }
        return $problems;
    }

}
