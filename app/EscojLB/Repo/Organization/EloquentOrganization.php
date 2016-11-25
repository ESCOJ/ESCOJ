<?php namespace EscojLB\Repo\Organization;

use Illuminate\Database\Eloquent\Model;

class EloquentOrganization implements OrganizationInterface {

    protected $organization;

    // Class expects an Eloquent model
    public function __construct(Model $organization)
    {
        $this->organization = $organization;
    }

   
    /**
     * Get all Organizations as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all Organizations
     */
    public function getKeyValueAll($key,$value)
    { 
      return $this->organization->pluck($value,$key);
    }

     /**
     * Get paginated Organizations
     *
     * @param int $limit Results per page
     * @param string $name  contains the string that us find in the title or id o any Organization
     * @return LengthAwarePaginator with the Organizations to paginate
     */
    public function getAllPaginate($limit = 10, $name){

        if( isset($name) )
            $this->organization = $this->organization->where(function ($query) use ($name) {
                    $query->where('name', 'like', '%'. $name . '%')
                          ->orWhere('id', 'like', '%'. $name . '%');
                });

        return $this->organization->paginate($limit);
    }

    /**
     * Create a new Organization
     *
     * @param string  Name to update an Organization
     * @return boolean id of the created Organization or zero if fails
     */
    public function create($name)
    {
        // Create the organization
        $organization = $this->organization->create(array(
            'name' => $name,
        ));
       
        if( ! $organization )
            return false;
        return true;
    }

    /**
     * Update an existing Organization
     *
     * @param string  Name to update an Organization
     * @param  int $id       Organization ID
     * @return boolean 
     */
    public function update($name, $id)
    {
        $organization = $this->organization->find($id);
        $organization->name = $name;
        return $organization->save();
    }

    /**
     * Get a Organization by Organization ID
     *
     * @param  int $id       Organization ID
     * @return Object    Organization model object
     */
    public function findById($id){
        return $this->organization->find($id);
    }

}