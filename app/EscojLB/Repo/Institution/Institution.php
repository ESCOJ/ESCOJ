<?php

namespace EscojLB\Repo\Institution;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
     protected $fillable = [ 'name','country_id',];
     public $timestamps = false;
    //building relationships

  	public function users(){
        return $this->hasMany('EscojLB\Repo\User\User');
    }

    public function country(){
        return $this->belongsTo('EscojLB\Repo\Country\Country');
    }

}
