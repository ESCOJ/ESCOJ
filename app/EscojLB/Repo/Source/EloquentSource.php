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

    /**
     * Get paginated sources
     *
     * @param int $limit Results per page
     * @param string $name  contains the string that us find in the title or id o any source
     * @return LengthAwarePaginator with the sources to paginate
     */
    public function getAllPaginate($limit = 10, $name){

        if( isset($name) )
            $this->source = $this->source->where(function ($query) use ($name) {
                    $query->where('name', 'like', '%'. $name . '%')
                          ->orWhere('id', 'like', '%'. $name . '%');
                });

        return $this->source->paginate($limit);
    }

    /**
     * Create a new Source
     *
     * @param string  Name to update an Source
     * @return boolean id of the created Source or zero if fails
     */
    public function create($name)
    {
        // Create the source
        $source = $this->source->create(array(
            'name' => $name,
        ));
       
        if( ! $source )
            return false;
        return true;
    }

    /**
     * Update an existing Source
     *
     * @param string  Name to update an Source
     * @param  int $id       Source ID
     * @return boolean 
     */
    public function update($name, $id)
    {
        $source = $this->source->find($id);
        $source->name = $name;
        return $source->save();
    }

    /**
     * Get a Source by Source ID
     *
     * @param  int $id       Source ID
     * @return Object    Source model object
     */
    public function findById($id){
        return $this->source->find($id);
    }

}