<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = ['App\Thread' => 'App\Policies\ThreadPolicy', 'App\Reply' => 'App\Policies\ReplyPolicy', 'App\User' => 'App\Policies\UserPolicy',];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user) {
            if ($user->isAdmin()) {
                return true;
            }
        });
        $this->registerPolicies();
    }
}
