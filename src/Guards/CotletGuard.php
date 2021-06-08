<?php

namespace SaeedVaziry\Cotlet\Guards;

use SaeedVaziry\Cotlet\Traits\Tokens;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CotletGuard implements Guard
{
    use GuardHelpers, Tokens;

    /**
     * @var Request
     */
    private $request;

    /**
     * ClientGuard constructor.
     * @param UserProvider $provider
     * @param Request $request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * @return Authenticatable|null
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        return $this->getUser();
    }

    /**
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $user = $this->getUser();

        return (bool)$user;
    }

    /**
     * @param Authenticatable $user
     * @return $this
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param array $credentials
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function attempt(array $credentials)
    {
        $user = call_user_func(config('cotlet.user_model') . '::query')
            ->where(config('cotlet.username_field'), $credentials[config('cotlet.username_field')])
            ->first();
        if (!$user) {
            return false;
        }
        if (!Hash::check($credentials[config('cotlet.password_field')], $user->{config('cotlet.password_field')})) {
            return false;
        }

        return $user;
    }

    /**
     * logout user and revoke token
     */
    public function logout()
    {
        $this->revokeToken($this->request->bearerToken());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function getUser()
    {
        try {
            $user = $this->getTokenable($this->request->bearerToken());

            if (!isset($user) || !$user) {
                return null;
            }

            $model = get_class(config('cotlet.user_model'));
            if ($user instanceof $model) {
                return $user;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
