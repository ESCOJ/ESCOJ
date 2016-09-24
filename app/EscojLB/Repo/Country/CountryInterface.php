<?php namespace EscojLB\Repo\Country;

interface CountryInterface {

    /**
     * Get all countries as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all countries
     */
    public function getKeyValueAll($key,$value);

}
