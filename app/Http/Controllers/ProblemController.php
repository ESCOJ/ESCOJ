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
use ESCOJ\Http\Requests\ProblemAssignLimitsRequest;
use ESCOJ\Constants;
use Validator;
use Storage;
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
                    $url = '/problem/limits/'.$problem_id;

                    return response()->json([
                        'message' => 'The problem has been created successfully.',
                        'redirect' => $url
                    ]);
                }
            }
        }
    }

     /**
     * Show the form for eding a existing problem.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $problem = $this->problem->findById($id);
        $sources = $this->source->getKeyValueAll('id','name');
        $tags = $this->inputToSelectTags();
        $languages = $this->language->getAll();
        return view('problem.update',['problem' => $problem, 'sources' => $sources,'tags' => $tags, 'languages' => $languages]);
    }

    /**
     * Update a existing problem.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProblemAddRequest $request ,$id)
    {
        dd($request->all());
        if($request->ajax()){
            if($request->action === Constants::CEATE_PROBLEM){
                $problem_id = $this->problem->create($request->all(),Auth::user()->id);
                if($problem_id){
                    $url = '/problem/limits/'.$problem_id;

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
     * Show the form for editing the limits of a problem in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function limits($id)
    {
        $problem = $this->problem->findById($id);
        $languages = $this->problem->getAllLanguages($id);
        $ids = array();
        foreach($languages as $language){
            $ids[] = $language->id;
        }
        return view('problem.assign_limits',['problem' => $problem, 'languages' => $languages, 'ids' => $ids]);
    }

    /**
     * Update the limits of a problem in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignLimits(ProblemAssignLimitsRequest $request, $id)
    {
        $languages = $this->problem->getKeyValueAllLanguages('name', 'id', $id);

        $request['languages'] = $languages->toArray();

        $problem = $this->problem->assignLimits($request->all(), $id);

        flash('The limits has been assigned successfully.','success')->important();

        return back()->with(['addDatasets' => 'true']);

    }

    /**
     * Show the form for editing the Datasets of a problem in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datasets($id)
    {
        $problem = $this->problem->findById($id);
        return view('problem.assign_datasets',['problem' => $problem]);
    }

    /**
     * Update the Datasets of a problem in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignDatasets(Request $request, $id)
    {
        
        //dd(storage_path('datasets/problem_4/'));
        $image = $request->file('dataset');
        $image->storeAs('/problem_'.$id, 'dataset_'.$id.'.zip', "datasets"); 

        $zip = new \ZipArchive();
        if ($zip->open(storage_path('datasets/problem_'.$id.'/dataset_'.$id.'.zip')) === TRUE) {
            $zip->extractTo(storage_path('datasets/problem_'.$id));
            $zip->close();
            Storage::disk('datasets')->delete('problem_'.$id.'/dataset_'.$id.'.zip');
        } 

        flash('The datasets has been loaded successfully.','success')->important();

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

}
