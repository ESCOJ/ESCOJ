<?php

namespace ESCOJ\Policies;

use EscojLB\Repo\User\User;
use EscojLB\Repo\Problem\Problem;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can perform some operations with the problem.
     *
     * @param  ESCOJ\User  $user
     * @param  ESCOJ\Problem  $problem
     * @return mixed
     */
    public function ownerOrAdmin(User $user, Problem $problem)
    {
     return ( ($user->id === $problem->added_by) or ($user->role === 'admin') ) ;
    }


}
