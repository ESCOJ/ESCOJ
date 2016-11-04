<?php

namespace EscojLB\Repo\Contest;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    //
    protected $fillable = [
        'name','organization_id', 'added_by', 'penalization', 'frozen_time', 'access_type', 'description','start_date', 'end_date', 'offcontest', 'offcontest_penalization', 'offcontest_start_date', 'offcontest_end_date',
    ];



    //building relationships

     public function organization(){
        return $this->belongsTo('EscojLB\Repo\Organization\Organization');
    }

    public function users(){
        return $this->belongsToMany('EscojLB\Repo\User\User');
    }

    public function user(){
        return $this->belongsTo('EscojLB\Repo\User\User', 'added_by');
    }

    public function problems(){
        return $this->belongsToMany('EscojLB\Repo\Problem\Problem')->withPivot('letter_id');
    }
}
