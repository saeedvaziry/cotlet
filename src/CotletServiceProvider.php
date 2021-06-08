<?php

namespace SaeedVaziry\Cotlet;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use SaeedVaziry\Cotlet\Guards\CotletGuard;

class CotletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // merge config file
        $this->mergeConfigFrom(__DIR__ . '/../config/cotlet.php', 'cotlet');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/cotlet.php');

        // define cotlet guard
        Auth::extend('cotlet', function ($app, $name, array $config) {
            return new CotletGuard(Auth::createUserProvider($config['provider']), app('request'));
        });
        Config::set('auth.providers.cotlet', [
            'driver' => 'eloquent',
            'model' => config('cotlet.user_model')
        ]);
        Config::set('auth.guards.cotlet', [
            'driver' => 'cotlet',
            'provider' => 'cotlet',
        ]);

        // publish configs
        $this->publishes([
            __DIR__ . '/../config/cotlet.php' => config_path('cotlet.php'),
        ], 'cotlet-config');

        // publish migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'cotlet-migrations');
    }
}
