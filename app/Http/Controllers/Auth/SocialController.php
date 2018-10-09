<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OAuthProvider;
use App\Http\Controllers\Controller;
use App\Exceptions\EmailTakenException;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\SocialLoginRequest;

class SocialController extends Controller
{
    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest:api')->except('logout');
    }

    public function social(SocialLoginRequest $request)
    {
        $request->validated();

        $user = $this->findOrCreateUser($request);

        $this->guard()->setToken(
            $token = $this->guard()->login($user, true)
        );

        $token = (string) $this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return [
            'success' => true,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration - time(),
        ];



    }

    protected function findOrCreateUser($user)
    {
        $oauthProvider = OAuthProvider::where('provider', $user->provider)
            ->where('provider_user_id', $user->provider_id)
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $user->access_token,
                'refresh_token' => $user->refresh_token,
            ]);

            return $oauthProvider->user;
        }

        if (User::where('email', $user->email)->exists()) {
            throw new EmailTakenException;
        }

        return $this->createUser($user);
    }


    protected function createUser($sUser)
    {
        if($sUser->accepted)
        $accepted = 1;
        else
        $accepted = 0;


        $user = User::create([
            'name' => $sUser->name,
            'last_name' => $sUser->last_name,
            'email' => $sUser->email,
            'avatar' => $sUser->avatar,
            'accepted_gdpr' => $accepted,
            'last_activity' => Carbon::now()
        ]);
        $user->syncRoles('user');
        $user->oauthProviders()->create([
            'provider' => $sUser->provider,
            'provider_user_id' => $sUser->provider_id,
            'access_token' => $sUser->access_token,
            'refresh_token' => $sUser->refresh_token,
        ]);

        return $user;
    }
}
