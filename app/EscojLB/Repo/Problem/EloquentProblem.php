<?php namespace EscojLB\Repo\Problem;

use EscojLB\Repo\Tag\TagInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentProblem implements ProblemInterface {

    protected $problem;
    protected $tag;

    // Class expects an Eloquent model
    public function __construct(Model $problem, TagInterface $tag)
    {
        $this->problem = $problem;
        $this->tag = $tag;
    }

    /**
     * Retrieve problem by id
     * regardless of status
     *
     * @param  int $id Problem ID
     * @return stdObject object of problem information
     */
    public function byId($id)
    {
        return $this->problem->where('id', $id)
                ->first();
    }

    /**
     * Get paginated problems
     *
     * @param int $page Number of problems per page
     * @param int $limit Results per page
     * @param boolean $all Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page=1, $limit=10, $all=false)
    {
        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        /*$query = $this->problem->with('status')
                               ->with('author')
                               ->with('tags')
                               ->orderBy('created_at', 'desc');*/
        $query = $this->problem->orderBy('created_at', 'desc');

        if( ! $all )
        {
            $query->where('status', 1);
        }

        $problems = $query->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalproblems($all);
        $result->items = $problems->all();

        return $result;
    }

    /**
     * Get single problem by URL
     *
     * @param string  URL slug of problem
     * @return object object of problem information
     */
    public function bySlug($slug)
    {
        return $this->problem->
                            ->where('slug', $slug)
                            ->first();
    }

   /**
     * Get problems by their tag
     *
     * @param string  URL slug of tag
     * @param int Number of problems per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($tag, $page=1, $limit=10)
    {
        $foundTag = $this->tag->where('slug', $tag)->first();

        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        if( !$foundTag )
        {
            return $result;
        }

        $problems = $this->tag->problems()
                        ->where('problems.status_id', 1)
                        ->orderBy('problems.created_at', 'desc')
                        ->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalByTag();
        $result->items = $problems->all();

        return $result;
    }

    /**
     * Create a new Problem
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        // Create the problem
        $problem = $this->problem->create(array(
            'name' => $data['name'],
            'author' => $data['author'],
            'tlpc' => $data['tlpc'],
            'ttl' => $data['ttl'],
            'ml' => $data['ml'],
            'sl' => $data['sl'],
            'description' => $data['description'],
            'input_specification' => $data['input_specification'],
            'output_specification' => $data['output_specification'],
            'sample_input' => $data['sample_input'],
            'sample_output' => $data['sample_output'],
            'hints' => $data['hints'],
            'points' => $data['points'],
            'status' => $data['status'],
        ));

        if( ! $problem )
        {
            return false;
        }

        $this->syncTags($problem, $data['tags']);

        return true;
    }

    /**
     * Update an existing Problem
     *
     * @param array  Data to update an Problem
     * @return boolean
     */
    public function update(array $data)
    {
        $problem = $this->problem->find($data['id']);
        $problem->name = $data['name'];
        $problem->author = $data['author'];
        $problem->tlpc = $data['tlpc'];
        $problem->ttl = $data['ttl'];
        $problem->ml = $data['ml'];
        $problem->sl = $data['sl'];
        $problem->description = $data['description'];
        $problem->input_specification = $data['input_specification'];
        $problem->output_specification = $data['output_specification'];
        $problem->sample_input = $data['sample_input'];
        $problem->sample_output = $data['sample_output'];
        $problem->hints = $data['hints'];
        $problem->points = $data['points'];
        $problem->status = $data['status'];
        $problem->save();

        $this->syncTags($problem, $data['tags']);

        return true;
    }

    /**
     * Sync tags for problem
     *
     * @param \Illuminate\Database\Eloquent\Model  $problem
     * @param array  $tags
     * @return void
     */
    protected function syncTags(Model $problem, array $tags)
    {
        // Create or add tags
        $found = $this->tag->find( $tags );

        $tagIds = array();

        foreach($found as $tag)
        {
            $tagIds[] = $tag->id;
        }

        // Assign set tags to problem
        $problem->tags()->sync($tagIds);
    }

    /**
     * Get total problem count
     *
     * @todo I hate that this is public for the decorators.
     *       Perhaps interface it?
     * @return int  Total problems
     */
    protected function totalproblems($all = false)
    {
        if( ! $all )
        {
            return $this->problem->where('status', 1)->count();
        }

        return $this->problem->count();
    }

    /**
     * Get total problem count per tag
     *
     * @todo I hate that this is public for the decorators
     *       Perhaps interface it?
     * @param  string  $tag  Tag slug
     * @return int     Total problems per tag
     */
    protected function totalByTag($tag)
    {
        return $this->tag->bySlug($tag)
                    ->problems()
                    ->where('status', 1)
                    ->count();
    }


}
