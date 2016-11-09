<?php

namespace ESCOJ\Policies;

use EscojLB\Repo\User\User;
use EscojLB\Repo\Contest\Contest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can perform some operations with the contest.
     *
     * @param  ESCOJ\User  $user
     * @param  ESCOJ\Contest  $contest
     * @return mixed
     */
    public function ownerOrAdmin(User $user, Contest $contest)
    {
     return ( ($user->id === $contest->added_by) or ($user->role === 'admin') ) ;
    }

    /**
     * Determine whether the user can perform some operations with the contest specifically if the user can submit or not.
     *
     * @param  ESCOJ\User  $user
     * @param  ESCOJ\Contest  $contest
     * @return mixed
     */
    public function belongs(User $user, Contest $contest)
    {
        return  $contest->users->contains($user->id);
    }

}
