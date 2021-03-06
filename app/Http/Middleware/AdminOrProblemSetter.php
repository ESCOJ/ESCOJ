<?php

namespace ESCOJ\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;

use Closure;

class AdminOrProblemSetter
{
    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = $this->auth->user()->role;

        if($role != 'admin' and $role != 'problem_setter'){
            flash('Some permissions are required to perform this operation.','info')->important();
            return redirect()->route('welcome');
        }
        return $next($request);
    }
}
