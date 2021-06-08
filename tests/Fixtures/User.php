<?php

namespace SaeedVaziry\Cotlet\Tests\Fixtures;

use SaeedVaziry\Cotlet\Traits\Cotlet;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Cotlet;

    protected $fillable = [
        'email', 'password'
    ];
}
