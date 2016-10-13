<?php namespace EscojLB\Repo\Language;

use Illuminate\Database\Eloquent\Model;

class EloquentLanguage implements LanguageInterface {

    protected $language;

    // Class expects an Eloquent model
    public function __construct(Model $language)
    {
        $this->language = $language;
    }

    /**
     * Get all languages as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all languages
     */
    public function getKeyValueAll($key,$value)
    { 
      return $this->language->pluck($value,$key);
    }

    /**
     * Retrieve all languages  
     * @return array        Array or Arrayable collection of Language objects
     */
    public function getAll(){
        return $this->language->all();
    }

    /**
     * Get a Language by Language ID
     *
     * @param  int $id       Language ID
     * @return Object    Language model object
     */
    public function findById($id){
        return $this->language->find($id);
    }

}