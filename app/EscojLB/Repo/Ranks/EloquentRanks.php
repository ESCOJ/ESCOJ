<?php namespace EscojLB\Repo\Ranks;

use Illuminate\Database\Eloquent\Model;
use EscojLB\Repo\User\UserInterface;
use Illuminate\Support\Facades\DB;

class EloquentRanks implements RanksInterface {

	protected $ranks;
    protected $user;

    // Class expects an Eloquent model
    public function __construct(Model $ranks, UserInterface $user)
    {
        $this->ranks = $ranks;
        $this->user = $user;
    }

         
}