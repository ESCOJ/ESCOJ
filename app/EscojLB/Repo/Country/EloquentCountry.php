<?php namespace EscojLB\Repo\Country;

use Illuminate\Database\Eloquent\Model;

class EloquentCountry implements CountryInterface {

    protected $country;

    // Class expects an Eloquent model
    public function __construct(Model $country)
    {
        $this->country = $country;
    }

    /**
     * Get all countries as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all countries
     */
    public function getKeyValueAll($key,$value)
    { 
      return $this->country->pluck($key,$value);
    }

}