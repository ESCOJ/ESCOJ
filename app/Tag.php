<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     protected $fillable = [ 'name','abbreviation',];

    //building relationships

 	public function problems(){
        return $this->belongsToMany('App\Problem')->withPivot('level');
    }
}
