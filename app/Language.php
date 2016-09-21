<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
     protected $fillable = [ 'name',];

    //building relationships

    public function problems(){
    	//the relationship without the withPivot method only provides the columns that form the pivot table, then we specify that also want the column multiplier of us pivot table
   	    return $this->belongsToMany('App\Problem')->withPivot('multiplier');
   	}
}
