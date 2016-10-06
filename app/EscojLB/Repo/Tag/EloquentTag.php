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

}