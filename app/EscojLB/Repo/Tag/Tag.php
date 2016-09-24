<?php

namespace ESCOJ;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     protected $fillable = [ 'name','abbreviation',];
     public $timestamps = false;
    //building relationships

 	public function problems(){
        return $this->belongsToMany('EscojLB\Repo\Problem\Problem')->withPivot('level');
    }
}
