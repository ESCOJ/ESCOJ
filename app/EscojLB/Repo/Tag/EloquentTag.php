<?php namespace EscojLB\Repo\Tag;

use Illuminate\Database\Eloquent\Model;

class EloquentTag implements TagInterface {

    protected $tag;

    // Class expects an Eloquent model
    public function __construct(Model $tag)
    {
        $this->tag = $tag;
    }

     /**
     * Get all tags as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all tags
     */
    public function getKeyValueAll($key,$value){
        return $this->tag->pluck($value,$key);
    }

      /**
     * Get a Tag by Tag ID
     *
     * @param  int $id       Tag ID
     * @return Object    Tag model object
     */
    public function findById($id){
        return $this->tag->find($id);
    }

    /**
     * Retrieve all Tags with eager loading of problems
     * @param  int $level   level of the tag asocciated to a problem
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function getAllWithProblemsByLevel($level){
        return $this->tag->with(['problems' => function($query) use ($level){
            $query->wherePivot('level', $level);
        }])->get();
    }

}