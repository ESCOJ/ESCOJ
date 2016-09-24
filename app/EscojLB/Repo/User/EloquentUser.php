<?php namespace EscojLB\Repo\User;


use Impl\Repo\problem\problemInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentUser implements UserInterface {

    protected $user;
    protected $problem;

    // Class expects an Eloquent model
    public function __construct(Model $user, ProblemInterface $problem)
    {
        $this->user = $user;
        $this->problem = $problem;
    }

    /**
     * Retrieve user by id
     * regardless of status
     *
     * @param  int $id user ID
     * @return stdObject object of user information
     */
    public function byId($id)
    {
        return $this->user->where('id', $id)
                ->first();
    }

    /**
     * Get paginated users
     *
     * @param int $page Number of users per page
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

        /*$query = $this->user->with('status')
                               ->with('author')
                               ->with('problems')
                               ->orderBy('created_at', 'desc');*/
        $query = $this->user->orderBy('created_at', 'desc');

        if( ! $all )
        {
            $query->where('status', 1);
        }

        $users = $query->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalusers($all);
        $result->items = $users->all();

        return $result;
    }

    /**
     * Get single user by URL
     *
     * @param string  URL slug of user
     * @return object object of user information
     */
    public function bySlug($slug)
    {
        return $this->user->
                            ->where('slug', $slug)
                            ->first();
    }

   /**
     * Get users by their problem
     *
     * @param string  URL slug of problem
     * @param int Number of users per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byproblem($problem, $page=1, $limit=10)
    {
        $foundproblem = $this->problem->where('slug', $problem)->first();

        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        if( !$foundproblem )
        {
            return $result;
        }

        $users = $this->problem->users()
                        ->where('users.status_id', 1)
                        ->orderBy('users.created_at', 'desc')
                        ->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalByproblem();
        $result->items = $users->all();

        return $result;
    }

    /**
     * Create a new user
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        // Create the user
        $user = $this->user->create(array(
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

        if( ! $user )
        {
            return false;
        }

        $this->syncproblems($user, $data['problems']);

        return true;
    }

    /**
     * Update an existing user
     *
     * @param array  Data to update an user
     * @return boolean
     */
    public function update(array $data)
    {
        $user = $this->user->find($data['id']);
        $user->name = $data['name'];
        $user->author = $data['author'];
        $user->tlpc = $data['tlpc'];
        $user->ttl = $data['ttl'];
        $user->ml = $data['ml'];
        $user->sl = $data['sl'];
        $user->description = $data['description'];
        $user->input_specification = $data['input_specification'];
        $user->output_specification = $data['output_specification'];
        $user->sample_input = $data['sample_input'];
        $user->sample_output = $data['sample_output'];
        $user->hints = $data['hints'];
        $user->points = $data['points'];
        $user->status = $data['status'];
        $user->save();

        $this->syncproblems($user, $data['problems']);

        return true;
    }

    /**
     * Sync problems for user
     *
     * @param \Illuminate\Database\Eloquent\Model  $user
     * @param array  $problems
     * @return void
     */
    protected function syncproblems(Model $user, array $problems)
    {
        // Create or add problems
        $found = $this->problem->find( $problems );

        $problemIds = array();

        foreach($found as $problem)
        {
            $problemIds[] = $problem->id;
        }

        // Assign set problems to user
        $user->problems()->sync($problemIds);
    }

    /**
     * Get total user count
     *
     * @todo I hate that this is public for the decorators.
     *       Perhaps interface it?
     * @return int  Total users
     */
    protected function totalusers($all = false)
    {
        if( ! $all )
        {
            return $this->user->where('status', 1)->count();
        }

        return $this->user->count();
    }

    /**
     * Get total user count per problem
     *
     * @todo I hate that this is public for the decorators
     *       Perhaps interface it?
     * @param  string  $problem  problem slug
     * @return int     Total users per problem
     */
    protected function totalByproblem($problem)
    {
        return $this->problem->bySlug($problem)
                    ->users()
                    ->where('status', 1)
                    ->count();
    }


}
