<?php

namespace SaeedVaziry\Cotlet\Tests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SaeedVaziry\Cotlet\Guards\CotletGuard;
use SaeedVaziry\Cotlet\Tests\Fixtures\User;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * @var
     */
    protected $user;

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array|string[]
     */
    protected function getPackageProviders($app)
    {
        return ['SaeedVaziry\Cotlet\CotletServiceProvider'];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array|string[]
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->artisan('migrate')->run();

        $this->loadMigrationsFrom(__DIR__ . '/../database/test-migrations');
        $this->artisan('migrate')->run();

        $this->user = User::query()->create([
            'email' => 'user@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ]);
    }
}
