<?php

namespace ESCOJ\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use ESCOJ\Http\Requests;
use ESCOJ\Http\Controllers\Controller;
use Socialite;
use EscojLB\Repo\User\UserInterface;
use EscojLB\Repo\User\User;
use EscojLB\Repo\Country\CountryInterface;
use Illuminate\Support\Facades\Auth;

use Redirect;

class SocialNetworkAccountController extends Controller
{

    protected $user;
    protected $country;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
    public function __construct(UserInterface $user , CountryInterface $country)
    {
        $this->user = $user;
        $this->country = $country;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function githubCallback()
    {

        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }
        
        if ( $authUser =$this->user->findByGithubId( $githubUser->id ) ) {
            Auth::login($authUser);
            return redirect('/');
        }

        $data['github_id'] = $githubUser->id;
        $data['name'] = $githubUser->name;
        $data['nickname'] = $githubUser->nickname;
        $data['email'] = $githubUser->email;

        return redirect('register')->with($data);

        
    }

}
