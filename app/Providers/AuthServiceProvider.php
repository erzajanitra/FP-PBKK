<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Services\Auth\JwtGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // before
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin) {
                return true;
            }
        });

        Gate::define('go-to-private', function ($user) {
            return($user->isAdmin);
        });

        Gate::define('update-private', function ($user) {
        return true;
        });

        // Gate responses
        Gate::define('go-to-response', function ($user) {
            return $user->isAdmin
                        ? Response::allow()
                        : Response::deny('You must be an administrator.');
        });

        // after, akan dijalankan terakhir
        // Gate::after(function ($user, $ability) {
        //     if ($user->isAdmin) {
        //         return true;
        //     }
        // });
    }
}
