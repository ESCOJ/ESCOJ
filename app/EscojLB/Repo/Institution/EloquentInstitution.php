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

}