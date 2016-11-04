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

}