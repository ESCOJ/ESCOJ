<?php

namespace EscojLB\Repo\Judgment;

use Illuminate\Database\Eloquent\Model;

class Judgment extends Model
{
    //
        protected $fillable = [
        	'submitted_at','language','memory','time','judgment','file_size','problem_id','user_id',
    	];
        public $timestamps = false;



    //building relationships

    public function users(){
        return $this->belongsTo('EscojLB\Repo\User\User');
    }

    public function problems(){
        return $this->belongsTo('EscojLB\Repo\Problem\Problem');
    }
}
