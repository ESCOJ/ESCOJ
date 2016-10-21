<?php namespace EscojLB\Repo\Problem;

use Illuminate\Database\Eloquent\Model;
use EscojLB\Repo\Tag\TagInterface;
use EscojLB\Repo\Language\LanguageInterface;
use Illuminate\Support\Facades\DB;
class EloquentProblem implements ProblemInterface {

    protected $problem;
    protected $tag;
    protected $language;

    // Class expects an Eloquent model
    public function __construct(Model $problem, TagInterface $tag, LanguageInterface $language)
    {
        $this->problem = $problem;
        $this->tag = $tag;
        $this->language = $language;

    }

    /**
     * Create a new Problem
     *
     * @param array  Data to create a new object
     * @param int  ID of the user that add the problem
     * @return boolean id of the created problem or zero if fails
     */
    public function create(array $data, $user_id)
    {
        // Create the problem
        $problem = $this->problem->create(array(
            'name' => $data['name'],
            'source_id' => $data['source'],
            'points' => $data['points'],
            'description' => $data['description'],
            'input_specification' => $data['input_specification'],
            'output_specification' => $data['output_specification'],
            'sample_input' => $data['sample_input'],
            'sample_output' => $data['sample_output'],
            'hints' => $data['hints'],
            'added_by' => $user_id,
            'enable' => $data['enable'],
            'multidata' => $data['multidata'],
        ));

        if( ! $problem )
            return 0;

        $this->syncTags($problem, $data['tags']);
        $this->syncLanguages($problem, $data['languages']);

        
        return $problem->id;
    }

    /**
     * Sync tags for problem
     *
     * @param \Illuminate\Database\Eloquent\Model  $problem
     * @param array  $tags
     * @return void
     */
    protected function synctags(Model $problem, array $tags)
    {

        $tagIds = array();

        foreach($tags as $tag)
        {
            $tagIds[explode('_',$tag)[0]] = array('level' => explode('_',$tag)[1]) ;
        }

        // Assign set tags to problem
        $problem->tags()->sync($tagIds);
    }

    /**
     * Sync languages for problem
     *
     * @param \Illuminate\Database\Eloquent\Model  $problem
     * @param array  $languages
     * @return void
     */
    protected function syncLanguages(Model $problem, array $languages, array $data = null)
    {
        $languageIds = array();
        if( is_null($data) )
        {
            if(array_has($languages,'All'))
            {
                $languages = $this->language->getAll();

                foreach ($languages as $language)
                {
                    $languageIds[$language->id] = array(
                        'tlpc_multiplier' => $language->tlpc_multiplier,
                        'ttl_multiplier' => $language->ttl_multiplier,
                        'ml_multiplier' => $language->ml_multiplier,
                        'sl_multiplier' => $language->sl_multiplier,
                        );
                }
            }
            else
            {
                foreach($languages as $id)
                {
                    $language = $this->language->findById($id);

                    if($language)
                    {
                        $languageIds[$id] = array(
                            'tlpc_multiplier' => $language->tlpc_multiplier,
                            'ttl_multiplier' => $language->ttl_multiplier,
                            'ml_multiplier' => $language->ml_multiplier,
                            'sl_multiplier' => $language->sl_multiplier,
                            );
                    }
                }
            }
        }
        else
        {
            foreach($languages as $id)
            {

                $languageIds[$id] = array(
                    'ml_multiplier' => $data['limits'][$id]['ml_multiplier'],
                    'sl_multiplier' => $data['limits'][$id]['sl_multiplier'],
                    'tlpc_multiplier' => $data['limits'][$id]['tlpc_multiplier'],
                    'ttl_multiplier' => $data['limits'][$id]['ttl_multiplier'],
               
                    'ml' => $data['limits'][$id]['ml'],
                    'sl' => $data['limits'][$id]['sl'],
                    'tlpc' => $data['limits'][$id]['tlpc'],
                    'ttl' => $data['limits'][$id]['ttl'],
        
                    );
            }
        }
        
        // Assign set languages to problem
        $problem->languages()->sync($languageIds);
    }

    /**
     * Update an existing Problem
     *
     * @param array  Data to update an problem
     * @param  int $id       Problem ID
     * @return boolean 
     */
    public function update(array $data, $id)
    {
        $problem = $this->problem->find($id);
        $problem->name = $data['name'];
        $problem->source_id = $data['source'];
        $problem->points = $data['points'];
        $problem->description = $data['description'];
        $problem->input_specification = $data['input_specification'];
        $problem->output_specification = $data['output_specification'];
        $problem->sample_input = $data['sample_input'];
        $problem->sample_output = $data['sample_output'];
        $problem->hints = $data['hints'];
        $problem->enable = $data['enable'];
        $problem->multidata = $data['multidata'];
        $problem->save();

        $this->syncTags($problem, $data['tags']);
        $this->syncLanguages($problem, $data['languages']);
        return true;
    }


    /**
     * Assign the limits to an existing Problem
     *
     * @param array  Data to update the limitis of the problem
     * @param  int $id       Problem ID
     * @return boolean 
     */
    public function assignLimits(array $data, $id){

        $problem = $this->problem->find($id);
        $problem->ml = $data['limits']['0']['ml'];
        $problem->sl = $data['limits']['0']['sl'];
        $problem->tlpc = $data['limits']['0']['tlpc'];
        $problem->ttl = $data['limits']['0']['ttl'];
        $problem->save();

        $this->syncLanguages($problem, $data['languages'],$data);
    }

     /**
     * Update the flag of an existing Problem that indicates whether the probles has or not dataset.
     *
     * @param int  flag to update the dataset flag of the problem 0 or 1.
     * @param  int $id       Problem ID
     * @return boolean 
     */
    public function addOrDeleteDataset(int $flag, $id){
        $problem = $this->problem->find($id);
        $problem->dataset = $flag;
        $problem->save();
    }

    /**
     * Retrieve all languages by Problem ID
     * @param  int $id       Problem ID
     * @return array        Array or Arrayable collection of Language objects
     */
    public function getAllLanguages($id){
        $problem = $this->findById($id);
        return $problem->languages;
    }

       /**
     * Get all languages as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @param  int $id       Problem ID
     * @return array    Associative Array with all languages
     */
    public function getKeyValueAllLanguages($key,$value,$id){
        $problem = $this->findById($id);
        return $problem->languages->pluck($value,$key);
    }

    /**
     * Get a Problem by Problem ID
     *
     * @param  int $id       Problem ID
     * @return Object    Problem model object
     */
    public function findById($id){
        return $this->problem->find($id);
    }

      /**
     * Get paginated problems
     *
     * @param int $limit Results per page
     * @return LengthAwarePaginator with the problems to paginate
     */
    public function getAllPaginate($limit=10){
        return $this->problem->where('enable', 1)->paginate($limit);
    }

     /**
     * Get filter paginated problems
     *
     * @param int $limit Results per page
     * @param array  Data that contains the filters to apply to the query.
     * @return LengthAwarePaginator with the problems to paginate
     */
    public function getAllPaginateFiltered($limit=10, array $data){
        if( $data['tag'] )
        {
            $problems = $this->tag->findById($data['tag'])->problems();

            if( $data['level'] )
                $problems->wherePivot('level', $data['level']);

            if( !empty($data['name']) )
                $problems->where('name', 'like', '%'. $data['name'] . '%');
            
            return $problems->where('enable',1)->paginate($limit);
        }

        else if( $data['level']){

            $problems_id = DB::select('select distinct problem_id from problem_tag where level = ?', [$data['level']]);
            
            $problems_id = array_map(function($object){
                return array_values((array) $object);
            }, $problems_id);

            $problems = $this->problem->whereIn('id', $problems_id);

            if( !empty($data['name']) )
                $problems->where('name', 'like', '%'. $data['name'] . '%');

            return $problems->where('enable',1)->paginate($limit);

            /*$tags = $this->tag->getAllWithProblemsByLevel( $data['level'] );

            foreach($tags as $tag){
                $problems = $tag->problems()->wherePivot('level', $data['level']);
                if( !empty($data['name']) )
                    $problems->where('name', 'like', '%'. $data['name'] . '%');
                
                dd($problems->where('enable',1)->get());

            }

            if( $data['level'] )
            {
                $problems->wherePivot('level', $data['level']);
            }
            if( !empty($data['name']) )
            {
                $problems->where('name', 'like', '%'. $data['name'] . '%');
            }
            
            $problems->where('enable',1)->paginate($limit);
            dd('shi');*/
        }

        return $this->problem->where('enable',1)->where('name', 'like', '%'. $data['name'] . '%')->paginate($limit);
    }

    /**
     * Get problems by their tag
     *
     * @param int  ID of tag
     * @param int Number of problems per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($tag_id, $limit=10)
    {

        $foundTag = $this->tag->findById($tag_id);

        $problems = $foundTag->problems()
            ->wherePivot('level',3)
            ->where('enable',1)
            //->where('name', 'like', '%'. $data['name'] . '%')
            ->paginate($limit);//->where('enable', 1)->get();

        dd($problems);

        return $problems->all();
    }



}
