<?php namespace EscojLB\Repo\Tag;

interface TagInterface {

    /**
     * Get all tags as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all tags
     */
    public function getKeyValueAll($key,$value);

    /**
     * Get a Tag by Tag ID
     *
     * @param  int $id       Tag ID
     * @return Object    Tag model object
     */
    public function findById($id);
   
    /**
     * Retrieve all Tags with eager loading of problems
     * @param  int $level   level of the tag asocciated to a problem
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function getAllWithProblemsByLevel($level);

}
