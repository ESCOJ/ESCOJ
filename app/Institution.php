<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
     protected $fillable = [ 'name','country_id',];
     public $timestamps = false;
    //building relationships

  	public function users(){
        return $this->hasMany('ESCOJ\User');
    }

    public function country(){
        return $this->belongsTo('ESCOJ\Country');
    }

    public static function institutions($id){
    	return Institution::where('country_id','=',$id)
    	->get();
    }
}
