<?php

namespace SaeedVaziry\Cotlet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class AccessToken extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'tokenable_id',
        'tokenable_type',
        'token',
        'revoked',
        'expires_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'tokenable_id' => 'integer',
        'revoked' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'access_token'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tokenable()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getAccessTokenAttribute()
    {
        return Crypt::encryptString($this->token);
    }

    /**
     * @param $accessToken
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|null
     */
    public static function findByAccessToken($accessToken)
    {
        try {
            $tokenPlain = Crypt::decryptString($accessToken);
            $token = self::query()
                ->where('token', $tokenPlain)
                ->firstOrFail();
            if ($token->revoked) {
                return null;
            }
            $expiresAt = new Carbon($token->expires_at);
            $now = new Carbon(now());
            if ($now > $expiresAt) {
                return null;
            }

            return $token;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * revoke token
     */
    public function revoke()
    {
        $this->update(['revoked' => 1]);
    }
}
