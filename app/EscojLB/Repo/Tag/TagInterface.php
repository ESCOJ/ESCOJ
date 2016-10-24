<?php namespace EscojLB\Repo\Tag;

interface TagInterface {

    /**
     * Find existing tags
     *
     * @param  Array $tags  Array of strings, each representing a tag
     * @return array         Array or Arrayable collection of Tag objects
     */
    public function find(array $tags);

    public function getAll($value, $key);

}
