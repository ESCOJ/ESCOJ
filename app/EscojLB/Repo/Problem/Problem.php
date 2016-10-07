<?php

namespace EscojLB\Repo\Problem;
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
        'name','tlpc','ttl', 'ml','sl','description','input_specification','output_specification','sample_input','sample_output','output_input','hints','points','status','slug','added_by','source_id'
    ];



    //building relationships

    public function tags(){
        return $this->belongsToMany('EscojLB\Repo\Tag\Tag')->withPivot('level');
    }

    public function judgments(){
        return $this->hasMany('EscojLB\Repo\Judgment\Judgment');
    }

    public function languages(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
   	    return $this->belongsToMany('EscojLB\Repo\Language\Language')->withPivot('multiplier');
   	}

    public function user(){
        return $this->belongsTo('EscojLB\Repo\User\User', 'added_by');
    }

    public function users(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
        return $this->belongsToMany('EscojLB\Repo\User\User')->withPivot('status');
    }

    public function contests(){
        return $this->belongsToMany('EscojLB\Repo\Contest\Contest');
    }

     public function source(){
        return $this->belongsTo('EscojLB\Repo\Source\Source');
    }
}
