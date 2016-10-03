<?php

namespace ESCOJ\Http\Controllers\Auth;

use Illuminate\Http\Request;
use ESCOJ\Http\Requests;
use ESCOJ\Http\Controllers\Controller;
use Socialite;
use EscojLB\Repo\User\UserInterface;
use Illuminate\Support\Facades\Auth;

use Redirect;

class SocialAuthController extends Controller
{

    protected $user;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Redirect the user to the GitHub or Facebook authentication page.
     *
     * @return Response
     */
    public function socialRedirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub or Facebook.
     *
     * @return Response
     */
    public function socialCallback($provider)
    {

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return Redirect::to('auth/redirect/' . $provider);
        }
        if ( $authUser =$this->user->findByProvider($provider,$socialUser->id ) ) {
            Auth::login($authUser);
            return redirect('/');
        }

        $data['provider'] = $provider;
        $data['provider_id'] = $socialUser->id;
        $data['name'] = $socialUser->name;
        $data['nickname'] = $socialUser->nickname;
        $data['email'] = $socialUser->email;

        return redirect('register')->with($data);

        
    }

}
