<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = [ 'name',];

    //building relationships

  	public function users(){
        return $this->hasMany('App\User');
    }

    public function institutions(){
        return $this->hasMany('App\Institution');
    }
}
  