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

}
