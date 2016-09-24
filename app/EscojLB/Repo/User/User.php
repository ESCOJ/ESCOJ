<?php

namespace EscojLB\Repo\User;

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
        'name','last_name','nickname', 'email', 'password','register_date','type','institution_id','country_id','points','avatar',
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
        return $this->belongsTo('EscojLB\Repo\Country\Country');
    }

    public function institution(){
        return $this->belongsTo('EscojLB\Repo\Institution\Institution');
    }

    public function contests(){
        return $this->belongsToMany('EscojLB\Repo\Contest\Contest');
    }

    public function judgments(){
        return $this->hasMany('EscojLB\Repo\Judgment\Judgment');
    }

    public function problems(){
        return $this->belongsToMany('EscojLB\Repo\Problem\Problem')->withPivot('status');
    }
}
