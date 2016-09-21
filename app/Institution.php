<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
     protected $fillable = [ 'name','country_id',];

    //building relationships

  	public function users(){
        return $this->hasMany('App\User');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }
}
