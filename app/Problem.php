<?php

namespace ESCOJ;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    //
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name','author','tlpc' 'ttl', 'ml','sl','description','input_specification','output_specification','sample_input','output_input','hints','points','status','slug',
    ];



    //building relationships

    public function tags(){
        return $this->belongsToMany('ESCOJ\Tag')->withPivot('level');
    }

    public function judgments(){
        return $this->hasMany('ESCOJ\Judgment');
    }

    public function languages(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
   	    return $this->belongsToMany('ESCOJ\Language')->withPivot('multiplier');
   	}

    public function users(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
        return $this->belongsToMany('ESCOJ\User')->withPivot('status');
    }

    public function contests(){
        return $this->belongsToMany('ESCOJ\Contest');
    }
}
