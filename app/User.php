<?php

namespace ESCOJ;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','nickname' 'email', 'password','register_date','type','institution_id','country_id','points',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //building relationships

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function institution(){
        return $this->belongsTo('App\Institution');
    }

    public function contests(){
        return $this->belongsToMany('App\Contest');
    }

    public function judgments(){
        return $this->hasMany('App\Judgment');
    }

    public function problems(){
        return $this->belongsToMany('App\Problem')->withPivot('status');
    }
}
