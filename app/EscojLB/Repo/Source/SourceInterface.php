<?php namespace EscojLB\Repo\Source;

interface SourceInterface {

    /**
     * Get all sources as key-value array 
     *
     * @param  string $key  key to associate
     * @param  string $value  value to associate
     * @return array    Associative Array with all sources
     */
    public function getKeyValueAll($key,$value);

}
