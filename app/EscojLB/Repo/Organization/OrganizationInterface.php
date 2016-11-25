<?php namespace EscojLB\Repo\Organization;

interface OrganizationInterface {

    /**
     * Get all Organizations as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all Organizations
     */
    public function getKeyValueAll($key,$value);

    /**
     * Get paginated Organizations
     *
     * @param int $limit Results per page
     * @param string $name  contains the string that us find in the title or id o any Organization
     * @return LengthAwarePaginator with the Organizations to paginate
     */
    public function getAllPaginate($limit = 10, $name);

    /**
     * Create a new Organization
     *
     * @param string  Name to update an Organization
     * @return boolean id of the created Organization or zero if fails
     */
    public function create($name);

    /**
     * Update an existing Organization
     *
     * @param string  Name to update an Organization
     * @param  int $id       Organization ID
     * @return boolean 
     */
    public function update($name, $id);

    /**
     * Get a Organization by Organization ID
     *
     * @param  int $id       Organization ID
     * @return Object    Organization model object
     */
    public function findById($id);

}
