<?php

namespace SaeedVaziry\Cotlet\Tests\Feature;

use Illuminate\Support\Facades\Crypt;
use SaeedVaziry\Cotlet\Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login()
    {
        $response = $this->json('post', route('cotlet.login'), [
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->assertDatabaseHas('access_tokens', [
            'tokenable_id' => $this->user->id,
            'token' => Crypt::decryptString($response->json()['access_token']),
            'revoked' => 0
        ]);
    }
}
