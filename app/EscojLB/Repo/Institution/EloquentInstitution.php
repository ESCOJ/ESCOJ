<?php namespace EscojLB\Repo\Institution;

use Illuminate\Database\Eloquent\Model;

class EloquentInstitution implements InstitutionInterface {

    protected $institution;

    // Class expects an Eloquent model
    public function __construct(Model $institution)
    {
        $this->institution = $institution;
    }

    /**
     * Get all institutions of a specific country  
     *
     * @param  int $id       Country ID
     * @return Collection    Institutions of a specific country
     */
    public function getInstitutionsByCountry($id)
    {
        return $this->institution->where('country_id','=',$id)->get();
    }

    /**
     * Get all institutions of a specific country as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @param  int $id       Country ID
     * @return array    Associative Array with all institutions of a given country
     */
    public function getInstitutionsKeyValueByCountry($key,$value,$id){
        return $this->institution->where('country_id','=',$id)->pluck($key,$value);
    }

}