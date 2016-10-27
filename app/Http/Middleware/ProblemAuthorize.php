<?php

namespace ESCOJ\Http\Middleware;

use Closure;
use Gate;
use EscojLB\Repo\Problem\Problem;


class ProblemAuthorize
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
       $problem = Problem::findOrFail($request->problem);

        Gate::authorize('ownerOrAdmin', $problem); 
               
        return $next($request);
    }
}
