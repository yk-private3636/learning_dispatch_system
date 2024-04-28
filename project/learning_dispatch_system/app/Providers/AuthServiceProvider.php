<?php

namespace App\Providers;

// use App\Providers\Auth\UserAuthProvider;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::provider(
            'user_auth_provider',
            function (Application $app, array $config) {
                return new EloquentUserProvider($app['hash'], $config['model']);
            }
        );
    }
}
