<?php

namespace EscojLB\Repo\Judgment;

use Illuminate\Database\Eloquent\Model;

class Judgment extends Model
{
    //
        protected $fillable = [
        	'submitted_at','language','memory','time','judgment','file_size','problem_id','user_id','contest','contest_id',
    	];
        public $timestamps = false;



    //building relationships

    public function user(){
        return $this->belongsTo('EscojLB\Repo\User\User');
    }

    public function problem(){
        return $this->belongsTo('EscojLB\Repo\Problem\Problem');
    }
    
    public function contest(){
        return $this->belongsTo('EscojLB\Repo\Contest\Contest');
    }
}
