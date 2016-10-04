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

}