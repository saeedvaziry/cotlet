<?php

namespace SaeedVaziry\Cotlet\Traits;

use SaeedVaziry\Cotlet\Models\AccessToken;

trait Cotlet
{
    use Tokens;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function accessTokens()
    {
        return $this->morphMany(AccessToken::class, 'tokenable');
    }
}
