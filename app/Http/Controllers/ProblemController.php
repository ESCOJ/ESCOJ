<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;

use ESCOJ\Http\Requests;
use EscojLB\Repo\Tag\TagInterface;
use EscojLB\Repo\Problem\ProblemInterface;
use EscojLB\Repo\Source\SourceInterface;
use EscojLB\Repo\Language\LanguageInterface;
use Illuminate\Support\Facades\Auth;
use ESCOJ\Http\Requests\ProblemDescriptionRequest;
use ESCOJ\Http\Requests\ProblemAssignLimitsRequest;
use ESCOJ\Http\Requests\ProblemAssignDatasetsRequest;
use ESCOJ\Constants;
use Validator;
use Storage;
use EscojLB\Repo\Problem\Problem;

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
     * Display a listing of the problem.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->all());
        if( $request->has('name') or $request->has('tag') or $request->has('level') )
            $problems = $this->problem->getAllPaginateFiltered(5, $request->all());   
        else
            $problems = $this->problem->getAllPaginate(5);

        $tags = $this->tag->getKeyValueAll('id','name');

        $levels = [
                '1' => 'Easy',
                '2' => 'Very Easy',
                '3' => 'Medium',
                '4' => 'Hard',
                '5' => 'Very Hard',
            ];
        $request->flash();
        return view('problem.index',['problems' => $problems, 'tags' => $tags, 'levels' => $levels]);
    }

    /**
     * Show the form for creating a new problem.
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
     * Store a newly created problem in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProblemDescriptionRequest $request)
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
        
        $problem_languages = $problem->languages;
        $languages_selected = array();
        foreach ($problem_languages as $language) {
            $languages_selected[$language->id] = $language->name;
        }

        $problem_tags = $problem->tags;
        foreach ($problem_tags as $tag) {
            $tags_selected []= $tag->id . '_' . $tag->pivot->level ;
        }

        $sources = $this->source->getKeyValueAll('id','name');
        $tags = $this->inputToSelectTags();
        $languages = $this->language->getAll();

        return view('problem.update',['problem' => $problem, 'sources' => $sources,'tags' => $tags,
                                     'languages' => $languages, 'languages_selected' => $languages_selected,
                                     'tags_selected' => $tags_selected]);
    }

    /**
     * Update a existing problem.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProblemDescriptionRequest $request ,$id)
    {
        if($request->ajax()){
            if($request->action === Constants::UPDATE_PROBLEM){
                $problem_id = $this->problem->update($request->all(),$id);
                if($problem_id){
                    $url = '/problem/limits/'.$id;

                    return response()->json([
                        'message' => 'The problem has been updated successfully.',
                        'redirect' => $url
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified problem.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $problem = $this->problem->findById($id);
        return view('problem.show_problem',['problem' => $problem]);
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

        $this->problem->assignLimits($request->all(), $id);

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
    public function assignDatasets(ProblemAssignDatasetsRequest $request, $id)
    {
        
        $dataset = $request->file('dataset');
        
        Storage::disk('datasets')->deleteDirectory('problem_'.$id);

        $dataset->storeAs('/problem_'.$id, 'dataset_'.$id.'.zip', "datasets"); 

        $zip = new \ZipArchive();
        if ($zip->open(storage_path('datasets/problem_'.$id.'/dataset_'.$id.'.zip')) === TRUE) {
            $zip->extractTo(storage_path('datasets/problem_'.$id));
            $zip->close();
            Storage::disk('datasets')->delete('problem_'.$id.'/dataset_'.$id.'.zip');

            $this->problem->addOrDeleteDataset( 1, $id);
        } 

        flash('The datasets has been loaded successfully.','success')->important();

        return back();

    }

    /**
     * Delete the Datasets of a problem in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDatasets(Request $request, $id)
    {
        
        if(Storage::disk('datasets')->deleteDirectory('problem_'.$id)){
            flash('The datasets has been removed successfully.','success')->important();
            $this->problem->addOrDeleteDataset( 0, $id);
        }
        else
            flash('The datasets could not be removed.','warning')->important();
        return back();

    }

        /**
     * Create the Dataset zip archive and Download it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadDatasets(Request $request, $id)
    {
        
        $path_dir = storage_path('datasets/problem_'.$id.'/');

        $file_name = 'problem_' .$id. '_dataset.zip';

        $path_file = $path_dir . $file_name;

        $zip = new \ZipArchive();

        if ($zip->open($path_file, \ZipArchive::CREATE) === TRUE) {    

            $files = $files = glob($path_dir . '*.*');

            foreach($files as $file)
                 $zip->addFile($file, basename($file));

            $zip->close();
        }

        $headers = array(
                'Content-Type' => 'application/octet-stream',
            );

        if(file_exists($path_file)){
            flash('The datasets has been downloaded successfully.','success')->important();
            return response()->download($path_file,$file_name,$headers)->deleteFileAfterSend(true);
        }

        flash('The datasets could not be downloaded.','danger')->important();
        return back();

    }

    /**
     * Remove the specified problem from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Generate the input to the tags selection.
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
