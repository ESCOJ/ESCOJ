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

}
