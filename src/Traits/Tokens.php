<?php

namespace SaeedVaziry\Cotlet\Traits;

use SaeedVaziry\Cotlet\Exceptions\InvalidToken;
use SaeedVaziry\Cotlet\Models\AccessToken;

trait Tokens
{
    /**
     * @param $user
     * @param int $expireInDays
     * @return mixed
     */
    protected function generateToken($user, int $expireInDays = 5)
    {
        $token = $user->accessTokens()->create([
            'token' => "{$user->id}_" . uniqid() . '_' . strtotime('now'),
            'expires_at' => now()->addDays($expireInDays)
        ]);

        return $token->access_token;
    }

    /**
     * @param $accessToken
     * @return mixed|string
     * @throws InvalidToken
     */
    protected function getTokenable($accessToken)
    {
        try {
            $token = AccessToken::findByAccessToken($accessToken);

            return $token->tokenable;
        } catch (\Exception $e) {
            throw new InvalidToken();
        }
    }

    /**
     * @param $accessToken
     */
    protected function revokeToken($accessToken)
    {
        try {
            $token = AccessToken::findByAccessToken($accessToken);

            if ($token) {
                $token->revoke();
            }
        } catch (\Exception $e) {
            //
        }
    }
}
