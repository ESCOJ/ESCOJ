<?php

namespace EscojLB\Repo;

use EscojLB\Repo\Country\EloquentCountry;
use EscojLB\Repo\Country\Country;
use EscojLB\Repo\Institution\EloquentInstitution;
use EscojLB\Repo\Institution\Institution;
use EscojLB\Repo\User\EloquentUser;
use EscojLB\Repo\User\User;
use EscojLB\Repo\Language\EloquentLanguage;
use EscojLB\Repo\Language\Language;
use EscojLB\Repo\Tag\EloquentTag;
use EscojLB\Repo\Tag\Tag;
use EscojLB\Repo\Problem\EloquentProblem;
use EscojLB\Repo\Problem\Problem;
use EscojLB\Repo\Source\EloquentSource;
use EscojLB\Repo\Source\Source;
use EscojLB\Repo\Judgment\EloquentJudgment;
use EscojLB\Repo\Judgment\Judgment;
use EscojLB\Repo\Organization\EloquentOrganization;
use EscojLB\Repo\Organization\Organization;
use EscojLB\Repo\Contest\EloquentContest;
use EscojLB\Repo\Contest\Contest;
use EscojLB\Repo\Ranks\EloquentRanks;
use EscojLB\Repo\Ranks\Ranks;

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

        $app->bind('EscojLB\Repo\Language\LanguageInterface', function($app)
        {
            $language =  new EloquentLanguage(new Language);
            return $language;

        });


        $app->bind('EscojLB\Repo\Tag\TagInterface', function($app)
        {
            $tag =  new EloquentTag(new Tag);
            return $tag;

        });

        $app->bind('EscojLB\Repo\Problem\ProblemInterface', function($app)
        {
            $problem =  new EloquentProblem(
                new Problem,
                $app->make('EscojLB\Repo\Tag\TagInterface'),
                $app->make('EscojLB\Repo\Language\LanguageInterface')
            );
            return $problem;

        });

        $app->bind('EscojLB\Repo\Source\SourceInterface', function($app)
        {
            $source =  new EloquentSource(new Source);
            return $source;

        });

        $app->bind('EscojLB\Repo\Judgment\JudgmentInterface', function($app)
        {
            $judgment =  new EloquentJudgment(new Judgment, $app->make('EscojLB\Repo\User\UserInterface'), $app->make('EscojLB\Repo\Contest\ContestInterface'));
            return $judgment;

        });

        $app->bind('EscojLB\Repo\Organization\OrganizationInterface', function($app)
        {
            $organization =  new EloquentOrganization(new organization);
            return $organization;

        });

        $app->bind('EscojLB\Repo\Contest\ContestInterface', function($app)
        {
            $contest =  new EloquentContest(new Contest, $app->make('EscojLB\Repo\Organization\OrganizationInterface'));
            return $contest;

        });

        $app->bind('EscojLB\Repo\Ranks\RanksInterface', function($app)
        {
            $rank =  new EloquentRanks(new Ranks, $app->make('EscojLB\Repo\User\UserInterface'));
            return $rank;

        });

    }
}
