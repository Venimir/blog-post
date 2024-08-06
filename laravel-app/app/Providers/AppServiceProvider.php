<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage_users', function(User $user) {
            return $user->hasRole('Admin');
        });
        Gate::define('manage_roles', function(User $user) {
            return $user->hasRole('Admin');
        });
        Gate::define('create_posts', function(User $user) {
            return $user->hasRole('Admin');
        });
        Gate::define('delete_posts', function(User $user) {
            return $user->hasRole('Admin');
        });
    }
}
