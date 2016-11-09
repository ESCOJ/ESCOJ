<?php

namespace ESCOJ\Http\Middleware;

use Closure;
use Gate;
use EscojLB\Repo\Contest\Contest;


class ContestAuthorize
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
       $contest = Contest::findOrFail($request->contest);

        Gate::authorize('ownerOrAdmin', $contest); 
               
        return $next($request);
    }
}
