<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use ESCOJ\Http\Requests\JudgmentAddRequest;
use ESCOJ\Http\Requests;
use EscojLB\Repo\Language\LanguageInterface;
use EscojLB\Repo\Tag\TagInterface;
use EscojLB\Repo\Judgment\JudgmentInterface;
use EscojLB\Repo\Problem\ProblemInterface;
use EscojLB\Repo\User\UserInterface;
use EscojLB\Repo\Contest\ContestInterface;
use ESCOJ\EscojLB\Grader;
use Illuminate\Support\Facades\Auth;
use Storage;


class JudgementController extends Controller
{

    protected $language;
    protected $tag;
    protected $problem;
    protected $judgment;
    protected $user;
    protected $contest;



    public function __construct(LanguageInterface $language,TagInterface $tag, JudgmentInterface $judgment, ProblemInterface $problem, UserInterface $user, ContestInterface $contest){

        $this->middleware('auth', ['except' => ['index']]);

        $this->language = $language;
        $this->tag = $tag;
        $this->problem = $problem;
        $this->judgment = $judgment;
        $this->user = $user;
        $this->contest = $contest;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if( $request->has('user') or $request->has('problem') or $request->has('language'))
            $judgments = $this->judgment->getAllPaginateFiltered(5, $request->all());
        else
            $judgments = $this->judgment->getAllPaginate(5);

        $tags = $this->tag->getAll('name','id');
        $languages = $this->language->getKeyValueAll('name','name');
        
        $request->flash();
        return view('judgment.index',['languages' => $languages, 'tags' => $tags, 'judgments' => $judgments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $problem_id)
    {
        $languages = $this->problem->getKeyValueAllLanguages('id','name',$problem_id);
        return view('judgment.add',['languages' => $languages,'id_problem' => $problem_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JudgmentAddRequest $request)
    {
        if($request->has('contest_id'))
            $this->authorize('belongs',$this->contest->findById($request->contest_id));

        $code = $request->input('your_code_in_the_editor');
        $language = $request->input('language');
        $problem_id = $request->input('problem_id');
        $file = $request->file('code');
        
        $id_user = Auth::user()->id;

        $limits = $this->problem->findLimitsByIdAndLanguage((int)$problem_id,(int)$language);
        
        $nickname = $this->user->getNickname($id_user);

        if($request->hasFile('code')){
            
            $file_splited = explode('.',$file->getClientOriginalName());

            $name = $nickname.'_'.$id_user."_".$problem_id . "." . $file_splited[1]; 

            $file_temp = $file->storeAs('/user_'.$id_user.'/problem_'.$problem_id, $name, "judgements");
            
        }
        else{
            $file_temp = Grader::buildCodeFile($file, $language, $problem_id, $code, $id_user, $nickname);
        }

        $RESULTS = Grader::evaluateCode($file_temp, $language, $problem_id, $id_user, $limits, $nickname);
            
            try{
                if($request->ajax()){
                    $this->judgment->create($RESULTS, $request->contest_id);
                    return response()->json([
                        'message' => 'The submission has been sent successfully.',
                    ]);
                }
                else
                    $this->judgment->create($RESULTS);
            }
            catch(\Exception $e){
                $excep = 'Error generated trying to submit';
                $request->session()->flash('alert-success', $excep);
            }
            return redirect()->route("judgment.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


