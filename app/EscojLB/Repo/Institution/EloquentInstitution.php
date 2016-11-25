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
        return $this->institution->where('country_id','=',$id)->pluck($value,$key);
    }

    /**
     * Get paginated Institutions
     *
     * @param int $limit Results per page
     * @param string $name  contains the string that us find in the title or id o any Institution
     * @param int $country  Country ID
     * @return LengthAwarePaginator with the Institutions to paginate
     */
    public function getAllPaginate($limit = 10, $name, $country){
        //dd($country);
        if( isset($country) )
             $this->institution = $this->institution->where('country_id', $country);
        if( isset($name) )
            $this->institution = $this->institution->where(function ($query) use ($name) {
                    $query->where('name', 'like', '%'. $name . '%')
                          ->orWhere('id', 'like', '%'. $name . '%');
                });

        return $this->institution->with('country')->paginate($limit);
    }

    /**
     * Create a new Institution
     *
     * @param string  Name to update an Institution
     * @param int $country  Country ID
     * @return boolean id of the created Institution or zero if fails
     */
    public function create($name, $country)
    {
        // Create the institution
        $institution = $this->institution->create(array(
            'name' => $name,
            'country_id' => $country,
        ));
       
        if( ! $institution )
            return false;
        return true;
    }

    /**
     * Update an existing Institution
     *
     * @param string  Name to update an Institution
     * @param int $country  Country ID
     * @param  int $id       Institution ID
     * @return boolean 
     */
    public function update($name, $country, $id)
    {
        $institution = $this->institution->find($id);
        $institution->name = $name;
        $institution->country_id = $country;
        return $institution->save();
    }

    /**
     * Get a institution by Institution ID
     *
     * @param  int $id       Institution ID
     * @return Object    Institution model object
     */
    public function findById($id){
        return $this->institution->find($id);
    }

}