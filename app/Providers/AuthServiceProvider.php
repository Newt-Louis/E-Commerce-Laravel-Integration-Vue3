<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\AuthenticationException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('admin-login', function (User $user) {
            return in_array($user->role, [1,2,3]);
        });

        foreach (['user'] as $model) {
            Gate::define("update-{$model}", function (User $user, $modelInstance) {
                return in_array($user->role, [1,2]);
            });
            Gate::define("delete-{$model}", function (User $user, $modelInstance) {
                return in_array($user->role, [1,2]);
            });
        };

    }
}
