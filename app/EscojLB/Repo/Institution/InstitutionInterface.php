<?php namespace EscojLB\Repo\Institution;

interface InstitutionInterface {

    /**
     * Get all institutions of a specific country  
     *
     * @param  int $id       Country ID
     * @return Collection    Institutions of a specific country
     */
    public function getInstitutionsByCountry($id);

}
