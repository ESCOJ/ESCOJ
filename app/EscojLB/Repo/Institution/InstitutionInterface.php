<?php namespace EscojLB\Repo\Institution;

interface InstitutionInterface {

    /**
     * Get all institutions of a specific country  
     *
     * @param  int $id       Country ID
     * @return Collection    Institutions of a specific country
     */
    public function getInstitutionsByCountry($id);

    /**
     * Get all institutions of a specific country as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @param  int $id       Country ID
     * @return array    Associative Array with all institutions of a given country
     */
    public function getInstitutionsKeyValueByCountry($key,$value,$id);

    /**
     * Get paginated Institutions
     *
     * @param int $limit Results per page
     * @param string $name  contains the string that us find in the title or id o any Institution
     * @param int $country  Country ID
     * @return LengthAwarePaginator with the Institutions to paginate
     */
    public function getAllPaginate($limit = 10, $name, $country);

    /**
     * Create a new Institution
     *
     * @param string  Name to update an Institution
     * @param int $country  Country ID
     * @return boolean id of the created Institution or zero if fails
     */
    public function create($name, $country);

    /**
     * Update an existing Institution
     *
     * @param string  Name to update an Institution
     * @param int $country  Country ID
     * @param  int $id       Institution ID
     * @return boolean 
     */
    public function update($name, $country, $id);

    /**
     * Get a Institution by Institution ID
     *
     * @param  int $id       Institution ID
     * @return Object    Institution model object
     */
    public function findById($id);

}
