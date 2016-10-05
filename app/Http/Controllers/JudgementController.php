<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use ESCOJ\Http\Requests\JudgmentAddRequest;
use ESCOJ\Http\Requests;
use EscojLB\Repo\Language\LanguageInterface;
use ESCOJ\Entities\EvaluateTool;

class JudgementController extends Controller
{

    protected $language;

    public function __construct(LanguageInterface $language){
        $this->language = $language;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	/* We can use either exec, passthru and system, but the exit it's different for everyone
    		$s1 = exec('ls -l');
			return view('submit.add', ['compiling' => $s1]);
        */
        $languages = $this->language->getKeyValueAll('id','name');
        return view('judgment.add',['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JudgmentAddRequest $request)
    {
        $code = $request->input('your_code_in_the_editor');
        $language = $request->input('language');
        $problem_id = $request->input('problem_id');
        $file = $request->file('code');

        if($request->hasFile('code')){

            $file_name = $file->getClientOriginalName();
            $file_splited = explode('.',$file_name);
            $name = $problem_id . "." . $file_splited[1]; 
            $file_temp = $file->storeAs('temp',$name,"judgements");
            
            EvaluateTool::evaluateCode($file_temp,$language,$problem_id);
        }else{
            $file_temp = EvaluateTool::buildCodeFile($file,$language,$problem_id,$code);
            $real_name_file = 'temp/'.$file_temp;
            EvaluateTool::evaluateCode($real_name_file,$language,$problem_id);
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


