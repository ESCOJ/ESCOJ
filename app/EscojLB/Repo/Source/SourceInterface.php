<?php namespace EscojLB\Repo\Source;

interface SourceInterface {

    /**
     * Get all sources as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all sources
     */
    public function getKeyValueAll($key,$value);

    /**
     * Get paginated sources
     *
     * @param int $limit Results per page
     * @param string $name  contains the string that us find in the title or id o any source
     * @return LengthAwarePaginator with the sources to paginate
     */
    public function getAllPaginate($limit = 10, $name);

    /**
     * Create a new Source
     *
     * @param string  Name to update an Source
     * @return boolean id of the created Source or zero if fails
     */
    public function create($name);

    /**
     * Update an existing Source
     *
     * @param string  Name to update an Source
     * @param  int $id       Source ID
     * @return boolean 
     */
    public function update($name, $id);

    /**
     * Get a Source by Source ID
     *
     * @param  int $id       Source ID
     * @return Object    Source model object
     */
    public function findById($id);

}
