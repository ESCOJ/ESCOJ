<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;

use ESCOJ\Http\Requests;
use EscojLB\Repo\Tag\TagInterface;
use EscojLB\Repo\Problem\ProblemInterface;
use EscojLB\Repo\Source\SourceInterface;
use Illuminate\Support\Facades\Auth;
use ESCOJ\Http\Requests\ProblemAddRequest;


class ProblemController extends Controller
{

    protected $tag;
    protected $problem;
    protected $source;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TagInterface $tag,ProblemInterface $problem,SourceInterface $source){
        $this->tag = $tag;
        $this->problem = $problem;
        $this->source = $source;
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
        return view('problem.add',['sources' => $sources,'tags' => $tags]);
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
            $this->problem->create($request->all(),Auth::user()->id);
            return response()->json([
                'message' => 'The data has been updated successfully.'
            ]);
        }
    }

    /**['data' => array('message' => 'thanks for registering!', 'redirecturl' => '/')]
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
                $options[$i+1 . '_' . $tag_id] = $levels[$i];
            }    
            $tags_classification[$tag_name] = $options;
        }

        return $tags_classification;

    }

}
