<?php

namespace EscojLB\Repo\Organization;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    //
    protected $fillable = [ 'name',];
    public $timestamps = false;

    //building relationships

  	public function contests(){
        return $this->hasMany('EscojLB\Repo\Contest\Contest');
    }
}
