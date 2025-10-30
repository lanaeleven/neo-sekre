<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        // Gate::define('dashboard-admin', function (User $user) {
        //     return $user->level === 'admin';
        // });

        // Gate::define('dashboard-direktur', function (User $user) {
        //     return $user->level === 'direktur';
        // });

        // Gate::define('dashboard-kepala', function (User $user) {
        //     return $user->level === 'kepala';
        // });

        // Gate::define('dashboard-penjab', function (User $user) {
        //     return $user->level === 'penjab';
        // });
    }
}
