<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;

use ESCOJ\Http\Requests\ContestDescriptionRequest;
use EscojLB\Repo\Organization\OrganizationInterface;
use EscojLB\Repo\Contest\ContestInterface;
use EscojLB\Repo\User\UserInterface;
use EscojLB\Repo\Problem\ProblemInterface;
use EscojLB\Repo\Judgment\JudgmentInterface;
use EscojLB\Repo\Language\LanguageInterface;
use Carbon\Carbon;

use Auth;

class ContestController extends Controller
{
    //
    protected $contest;
    protected $user;
    protected $organization;
    protected $problem;
    protected $judgment;
    protected $language;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationInterface $organization, ContestInterface $contest,
    						    UserInterface $user , ProblemInterface $problem, JudgmentInterface $judgment,
                                LanguageInterface $language){

        $this->middleware('auth', ['except' => ['index'] ]);
        $this->middleware('adminProblemSetterOrCoach', ['except' => ['index','show', 'showProblem','showJudgments','showScoreBoard', 'getUsersToScoreBoard'] ]);
        $this->middleware('contestAuthorize', ['only' => ['edit', 'update', 'destroy'] ]);
        
        $this->organization = $organization;
        $this->contest = $contest;
        $this->user = $user;
        $this->problem = $problem;
        $this->judgment = $judgment;
        $this->language = $language;
    }

    /**
     * Display a listing of the contest.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	//dd(date_format(date_create(),"Y-m-d H:i:s"));
        if( $request->has('name') or $request->has('organization') or $request->has('time') )
            $contests = $this->contest->getAllPaginateFiltered(5, $request->all());   
        else
            $contests = $this->contest->getAllPaginate(5);

        $organizations = $this->organization->getKeyValueAll('id','name');

        $times = [
                'future' => 'Future contests',
                'current' => 'Current contests',
                'past' => 'Past contests',
            ];

        $request->flash();
        return view('contest.index',['contests' => $contests, 'organizations' => $organizations, 'times' => $times]);
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
     * Show the form for editing a existing contest.
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

     /**
     * Display the specified contest.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $contest = $this->contest->findById($id);
        $contest_type = $this->getContestStatus($contest->start_date, $contest->end_date);

        if($contest->access_type == 'public' and $contest_type == 'current')
            $this->contest->attach($id, Auth::user()->id);
        

        $languages = $this->language->getKeyValueAll('id','name');
        $problems_map = array();
        foreach($contest->problems()->orderBy('letter_id')->get() as $problem)
            $problems_map[$problem->id] = $problem->pivot->letter_id;

        return view('contest.show',['contest' => $contest , 'in_contest' => true, 'languages' => $languages,
                                    'problems_map' => $problems_map, 'contest_type' => $contest_type]);
    }

    /**
     * Display the specified problem.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProblem(Request $request,$problem_id,$contest_id)
    {
        $contest = $this->contest->findById($contest_id);
        $problem = $this->problem->findById($problem_id);
        if($request->ajax()){
            return response()->json(view('contest.partials.show_contest.problem',
                                            ['problem' => $problem, 'contest' => $contest])->render());
        }
    }

    /**
     * Display the specified problem.
     *
     * @return \Illuminate\Http\Response
     */
    public function showJudgments(Request $request, $contest_id)
    {
        $contest_data = $this->getContestDataToFilterJudgmentsAndScoreBoard( $contest_id);

        if( $request->has('user') or $request->has('problem') or $request->has('language'))
            $judgments = $this->judgment->getAllPaginateFiltered(5, $request->all(), $contest_data);
        else
            $judgments = $this->judgment->getAllPaginate(5, $contest_data);

        $languages = $this->language->getKeyValueAll('name','name');
        $request->flash();
        if($request->ajax()){
            if($request->has('filter_or_paginate'))
                return response()->json(view('contest.partials.show_contest.judgments_table',['languages' => $languages, 'judgments' => $judgments])->render());
            return response()->json(view('contest.partials.show_contest.index_judgments',['languages' => $languages, 'judgments' => $judgments, 'contest_id' => $contest_id])->render());
        }

    }

    /**
     * Display the specified problem.
     *
     * @return \Illuminate\Http\Response
     */
    public function showScoreBoard(Request $request,$contest_id)
    {
        $problems = $this->contest->getAllProblemsOrderByLetterId($contest_id);

        $users = $this->getUsersToScoreBoard( $contest_id ,$problems);

        if($request->ajax()){
            return response()->json(view('contest.partials.show_contest.scoreboard',
                                            ['users' => $users, 'problems'  => $problems])->render());
        }
    }

    /**
     * Generate the data to scoreboard table.
     *
     * @return Collection
     */
    protected function getUsersToScoreBoard( $contest_id ,$problems)
    {

        $penal_and_start = $this->contest->getPenalizationTimeAndStartDate($contest_id);
        $penalization = $penal_and_start->penalization;
        $start_date = $penal_and_start->start_date;

        $users = $this->contest->getAllUsersWithJudgmentsByContest( 
                                    $this->getContestDataToFilterJudgmentsAndScoreBoard($contest_id) 
                                );
        $format = collect(['avatar', 'nickname', 'problems'])->merge(['time','AC']);
        
        $users_collection = collect();

        foreach ($users as $user) {

            $problems_collection = collect($problems->flip()->map(function ($item, $key) {
                return $item = collect(['status', 'attempts', 'min']);
            }));

            $accepteds = $time = 0;

            foreach ($problems as $problem_id => $problem_letter) {
                $judgments = $user->judgments->where('problem_id',$problem_id);
                
                $status = 'no attempted';
                $min = 0;
                $judgments_accepteds = $judgments->where('judgment','Accepted');
                $attempts = $judgments->where('judgment','!=','Accepted')->count();
                if($judgments_accepteds->count() > 0){
                        $status = 'accepted';
                        $accepteds++;
                        $min = (int)floor(abs(strtotime($judgments_accepteds->first()->submitted_at) - strtotime($start_date)) /60);
                        $time+= $attempts * $penalization + $min;
                }
                else if ($judgments->count() > 0)
                    $status = 'attempted';

                $problems_collection[$problem_letter] = $problems_collection[$problem_letter]->combine([$status, $attempts, $min]);
            }

            $users_collection->push( $format->combine([$user->avatar, $user->nickname, 'problems' => $problems_collection,
                                    $time, $accepteds]) );
        }
        

        return  $users_collection->sort( function ($a, $b) {
                                                if($a['AC'] === $b['AC']){
                                                    if($a['time'] === $b['time'])
                                                        return 0;
                                                    return ($a['time'] < $b['time']) ? -1 : 1;
                                                }

                                                return ($a['AC'] < $b['AC']) ? 1 : -1;
                                            })->values();
    }

    /**
     * Generate the data to filter the judgments to judgments table and scoreboar considering the logic to frozen time.
     *
     * @return Collection
     */
    protected function getContestDataToFilterJudgmentsAndScoreBoard( $contest_id ){
        $contest = $this->contest->findById($contest_id);
        $data['contest_id'] = $contest->id;
        $data['status'] = $this->getContestStatus($contest->start_date, $contest->end_date);

        if($data['status'] == 'current'){
            $data['limit_date_time'] = (new Carbon($contest->end_date))->subMinutes($contest->frozen_time)->format('Y-m-d H:i:s');
            $data['user_id'] = Auth::user()->id; 
        }
        return $data;
    }

    /**
     * Determine the status time of a contest
     *
     * @return String
     */
    protected function getContestStatus( $st_date, $ed_date ){
        $start_date = strtotime($st_date);
        $end_date = strtotime($ed_date); 
        $now = strtotime("now");
        return  ( ($start_date <= $now)  and ($end_date > $now) ) ? 'current' : (( $start_date > $now) ? 'future': 'past'); 
    }


}
