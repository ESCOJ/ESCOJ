<?php namespace EscojLB\Repo\Language;

interface LanguageInterface {

    /**
     * Get all languages as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all languages
     */
    public function getKeyValueAll($key,$value);

     /**
     * Retrieve all languages  
     * @return array        Array or Arrayable collection of Language objects
     */
    public function getAll();

    /**
     * Get a Language by Language ID
     *
     * @param  int $id       Language ID
     * @return Object    Language model object
     */
    public function findById($id);

}
