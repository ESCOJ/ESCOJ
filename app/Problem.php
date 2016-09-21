<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    //
    protected $fillable = [
        'name','author','tlpc' 'ttl', 'ml','sl','description','input_specification','output_specification','sample_input','output_input','hints','points','status',
    ];



    //building relationships

    public function tags(){
        return $this->belongsToMany('App\Tag')->withPivot('level');
    }

    public function judgments(){
        return $this->hasMany('App\Judgment');
    }

    public function languages(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
   	    return $this->belongsToMany('App\Language')->withPivot('multiplier');
   	}

    public function users(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
        return $this->belongsToMany('App\User')->withPivot('status');
    }

    public function contests(){
        return $this->belongsToMany('App\Contest');
    }
}
