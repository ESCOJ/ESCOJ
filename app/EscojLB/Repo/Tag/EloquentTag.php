<?php namespace EscojLB\Repo\Tag;

use Illuminate\Database\Eloquent\Model;

class EloquentTag implements TagInterface {

    protected $tag;

    // Class expects an Eloquent model
    public function __construct(Model $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Find existing tags or create if they don't exist
     *
     * @param  array $tags  Array of strings, each representing a tag
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function find(array $tags)
    {
        $foundTags = $this->tag->whereIn('name', $tags)->get();

        $returnTags = array();

        if( $foundTags )
        {
            foreach( $foundTags as $tag )
            {
                $pos = array_search($tag->tag, $tags);

                // Add returned tags to array
                if( $pos !== false )
                {
                    $returnTags[] = $tag;
                    unset($tags[$pos]);
                }
            }
        }

        return $returnTags;
    }

}