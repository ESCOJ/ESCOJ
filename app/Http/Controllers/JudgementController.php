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
use ESCOJ\EscojLB\EvaluateTool;
use Illuminate\Support\Facades\Auth;

class JudgementController extends Controller
{

    protected $language;
    protected $tag;
    protected $problem;
    protected $user;

    public function __construct(LanguageInterface $language,TagInterface $tag, JudgmentInterface $judgment, ProblemInterface $problem,UserInterface $user){
        $this->language = $language;
        $this->tag = $tag;
        $this->problem = $problem;
        $this->judgment = $judgment;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*if( $request->has('user') or $request->has('problem') or $request->has('languages'))
            $judgments = $this->judgment->getAllPaginateFiltered(10, $request->all());
        else*/
            $judgments = $this->judgment->getAllOrderedBySubmitted(10);

        $tags = $this->tag->getAll('name','id');
        $languages = $this->language->getKeyValueAll('id','name');
        
        return view('judgment.index',['languages' => $languages, 'tags' => $tags, 'judgments' => $judgments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $languages = $this->language->getKeyValueAll('id','name');
        return view('judgment.add',['languages' => $languages,'id_problem' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JudgmentAddRequest $request)
    {
        $excep = '';
        $code = $request->input('your_code_in_the_editor');
        $language = $request->input('language');
        $problem_id = $request->input('problem_id');
        $file = $request->file('code');
        
        $id_user = Auth::user()->id;
        $limits = $this->problem->findLimitsByIdAndLanguage((int)$id_user,(int)$language);

        if($request->hasFile('code')){
            //This user nickname is only for java rename class
            $nickname = $this->user->getNickname(1);
            $file_name = $file->getClientOriginalName();
            $file_splited = explode('.',$file_name);
            if($language == '3')
                $name = $nickname.'_'.$id_user."_".$problem_id . "." . $file_splited[1]; 
            else
                $name = $id_user."_".$problem_id . "." . $file_splited[1]; 
            $file_temp = $file->storeAs('temp',$name,"judgements");
            

            $RESULTS = EvaluateTool::evaluateCode($file_temp,$language,$problem_id,$id_user,$limits,$nickname);
            
            try{
                $this->judgment->create($RESULTS);
            }
            catch(\Exception $e){
                $excep = 'Error generated trying to submit';
                $request->session()->flash('alert-success', $excep);
            }
            
            return redirect()->route("judgment.index");
        }else{
            $file_temp = EvaluateTool::buildCodeFile($file,$language,$problem_id,$code,$id_user);
            $real_name_file = 'temp/'.$file_temp;
            $RESULTS = EvaluateTool::evaluateCode($real_name_file,$language,$problem_id,$id_user,$limits,$nickname);
            try{
                $this->judgment->create($RESULTS);
            }
            catch(\Exception $e){
                $excep = 'Error generated trying to submit';
                $request->session()->flash('alert-success', $excep);
            }
            
            return redirect()->route("judgment.index");
        }
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


