<?php

namespace EscojLB\Repo\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use ESCOJ\Notifications\ResetPassword as ResetPasswordNotification;
use ESCOJ\Notifications\ConfirmAccount;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','nickname', 'email', 'password','register_date','type','institution_id','country_id','points','avatar','confirmation_code', 'provider','provider_id',
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

    public function problems_added(){
        return $this->hasMany('EscojLB\Repo\Problem\Problem', 'added_by');
    }

    public function problems(){
        return $this->belongsToMany('EscojLB\Repo\Problem\Problem')->withPivot('status');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the confirmation account notification.
     *
     * @param  string  $confirmation_code
     * @return void
     */
    public function sendConfirmAccountNotification($confirmation_code)
    {
        $this->notify(new ConfirmAccount($confirmation_code));
    }
}
