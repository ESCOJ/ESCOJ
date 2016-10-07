<?php

namespace EscojLB\Repo\Source;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [ 'name',];
    public $timestamps = false;
    //building relationships

  	public function problems(){
        return $this->hasMany('EscojLB\Repo\Problem\Problem');
    }
}
