<?php

namespace EscojLB\Repo\Ranks;

use Illuminate\Database\Eloquent\Model;

class Ranks extends Model{

	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo('EscojLB\Repo\Ranks\Ranks');
	}
}