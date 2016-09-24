<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = [ 'name',];
    public $timestamps = false;
    //building relationships

  	public function users(){
        return $this->hasMany('ESCOJ\User');
    }

    public function institutions(){
        return $this->hasMany('ESCOJ\Institution');
    }
}
  