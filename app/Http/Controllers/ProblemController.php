<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;

use ESCOJ\Http\Requests;
use EscojLB\Repo\Tag\TagInterface;
use EscojLB\Repo\Problem\ProblemInterface;
use EscojLB\Repo\Source\SourceInterface;
use EscojLB\Repo\Language\LanguageInterface;
use Illuminate\Support\Facades\Auth;
use ESCOJ\Http\Requests\ProblemAddRequest;
use ESCOJ\Constants;
use Validator;

class ProblemController extends Controller
{

    protected $tag;
    protected $problem;
    protected $source;
    protected $language;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TagInterface $tag,ProblemInterface $problem,SourceInterface $source,LanguageInterface $language){
        $this->tag = $tag;
        $this->problem = $problem;
        $this->source = $source;
        $this->language = $language;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources = $this->source->getKeyValueAll('id','name');
        $tags = $this->inputToSelectTags();
        $languages = $this->language->getAll();
        return view('problem.add',['sources' => $sources,'tags' => $tags, 'languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProblemAddRequest $request)
    {
        if($request->ajax()){
            if($request->action === Constants::CEATE_PROBLEM){
                $problem_id = $this->problem->create($request->all(),Auth::user()->id);
                if($problem_id){
                    $url = '/problem/'.$problem_id.'/edit';
                    return response()->json([
                        'message' => 'The problem has been created successfully.',
                        'redirect' => $url
                    ]);
                }
            }
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
        $problem = $this->problem->findById($id);
        $languages = $this->problem->getAllLanguages($id);
        $ids = array();
        foreach($languages as $language){
            $ids[] = $language->id;
        }
        return view('problem.add_or_update',['problem' => $problem, 'languages' => $languages, 'ids' => $ids]);
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
        $languages = $this->problem->getKeyValueAllLanguages('name', 'id', $id);}

        $this->validator($request->all(),$languages->toArray())->validate();

        $request['languages'] = $languages->toArray();

        $problem = $this->problem->assignLimits($request->all(), $id);

        flash('The limits has been assigned successfully.','success')->important();
        return back();

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

    /**
     * Generate the input to the tags selction.
     *
     * @return \Illuminate\Http\Response
     */
    public function inputToSelectTags()
    {
        
        $tags = $this->tag->getKeyValueAll('id','name');
        $levels = array('Very Easy', 'Easy', 'Medium', 'Hard', 'Very Hard' );
        $tags_classification = array();

        foreach ($tags as $tag_id => $tag_name) {
            $options = array();
            for ($i=0; $i < 5; $i++) { 
                $options[$tag_id . '_' . ($i+1)] = $levels[$i];
            }    
            $tags_classification[$tag_name] = $options;
        }

        return $tags_classification;

    }


        /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $languages)
    {
        $rules = array();

        $messages = [
            'same'    => 'The :attribute and :other must match.',
            'size'    => 'The :attribute must be exactly :size.',
            'between' => 'The :attribute must be between :min - :max.',
            'in'      => 'The :attribute must be one of the following types: :values',
        ];

        $rules['tlpc'] = 'required|digits_between:1,10';
        $rules['ttl'] = 'required|digits_between:1,10';
        $rules['ml'] = 'required|digits_between:1,10';
        $rules['sl'] = 'required|digits_between:1,10';

        foreach($languages as $id)
        {
            $rules['tlpc_multiplier_'.$id] = 'required|numeric';
            $rules['ttl_multiplier_'.$id] = 'required|numeric';
            $rules['ml_multiplier_'.$id] = 'required|numeric';
            $rules['sl_multiplier_'.$id] = 'required|numeric';

            $rules['tlpc_'.$id] = 'required|digits_between:1,10';
            $rules['ttl_'.$id] = 'required|digits_between:1,10';
            $rules['ml_'.$id] = 'required|digits_between:1,10';
            $rules['sl_'.$id] = 'required|digits_between:1,10';
        }

        return Validator::make($data, $rules);
    }

}
