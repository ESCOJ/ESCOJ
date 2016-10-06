<?php namespace EscojLB\Repo\Tag;

interface TagInterface {

    /**
     * Get all tags as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all tags
     */
    public function getKeyValueAll($key,$value);

}
