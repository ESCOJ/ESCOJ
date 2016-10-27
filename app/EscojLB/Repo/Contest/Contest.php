<?php

namespace EscojLB\Repo\Contest;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    //
    protected $fillable = [
        'name','organization_id','start_date' 'end_date','description','acces_type','penalization','frozen_time','offcontest','offcontes_start_date','offcontest_end_date','offcontest_penalization',
    ];



    //building relationships

     public function organization(){
        return $this->belongsTo('EscojLB\Repo\Organization\Organization');
    }

    public function users(){
        return $this->belongsToMany('EscojLB\Repo\User\User');
    }

    public function problems(){
        return $this->belongsToMany('EscojLB\Repo\Problem\Problem');
    }
}
