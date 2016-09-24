<?php 

namespace EscojLB\Repo\Country;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = [ 'name',];
    public $timestamps = false;
    //building relationships

  	public function users(){
        return $this->hasMany('EscojLB\Repo\User\User');
    }

    public function institutions(){
        return $this->hasMany('EscojLB\Repo\Institution\Institution');
    }
}
  