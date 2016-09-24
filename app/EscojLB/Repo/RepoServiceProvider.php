<?php

namespace EscojLB\Repo;

use EscojLB\Repo\Country\EloquentCountry;
use EscojLB\Repo\Country\Country;
use EscojLB\Repo\Institution\EloquentInstitution;
use EscojLB\Repo\Institution\Institution;
use EscojLB\Repo\User\EloquentUser;
use EscojLB\Repo\User\User;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind('EscojLB\Repo\Country\CountryInterface', function($app)
        {
            $country =  new EloquentCountry(new Country);

            return $country;

        });

        $app->bind('EscojLB\Repo\Institution\InstitutionInterface', function($app)
        {
            $institution =  new EloquentInstitution(new Institution);

            return $institution;

        });

        $app->bind('EscojLB\Repo\User\UserInterface', function($app)
        {
            $user =  new EloquentUser(new User);
            return $user;

        });

        /*$app->bind('Impl\Repo\Tag\TagInterface', function($app)
        {
            return new EloquentTag(
                new Tag,
                new LaravelCache($app['cache'], 'tags', 10)
            );
        });

        $app->bind('Impl\Repo\Status\StatusInterface', function($app)
        {
            return new EloquentStatus(
                new Status
            );
        });*/
    }
}
