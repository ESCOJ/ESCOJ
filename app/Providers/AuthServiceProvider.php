<?php

namespace ESCOJ\Providers;
use EscojLB\Repo\Problem\Problem;
use ESCOJ\Policies\ProblemPolicy;
use EscojLB\Repo\Contest\Contest;
use ESCOJ\Policies\ContestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'ESCOJ\Model' => 'ESCOJ\Policies\ModelPolicy',
        Problem::class => ProblemPolicy::class,
        Contest::class => ContestPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
