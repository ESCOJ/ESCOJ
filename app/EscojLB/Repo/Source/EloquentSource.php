<?php namespace EscojLB\Repo\Source;

use Illuminate\Database\Eloquent\Model;

class EloquentSource implements SourceInterface {

    protected $source;

    // Class expects an Eloquent model
    public function __construct(Model $source)
    {
        $this->source = $source;
    }

   
    /**
     * Get all sources as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all sources
     */
    public function getKeyValueAll($key,$value)
    { 
      return $this->source->pluck($value,$key);
    }

}