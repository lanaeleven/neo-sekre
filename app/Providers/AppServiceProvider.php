<?php

namespace App\Providers;

use App\Models\DistribusiSurat;
use App\Models\User;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Carbon::setLocale('id');

        Paginator::useBootstrapFive();

        Gate::define('super-admin', function (User $user) {
            return ($user->id == 1 || $user->id == 2);
        });

        Gate::define('dashboard-sekre', function (User $user) {
            return ($user->id == 1 || $user->id == 2);
        });

        Gate::define('dashboard-not-sekre', function (User $user) {
            return ($user->id != 1 && $user->id != 2);
        });

        Gate::define('dashboard-direktur', function (User $user) {
            return $user->level == 'direktur';
        });

        Gate::define('dashboard-kepala', function (User $user) {
            return $user->level == 'kepala';
        });

        Gate::define('dashboard-penjab', function (User $user) {
            return $user->level == 'penjab';
        });

        Gate::define('disposisi-surat', function (User $user, DistribusiSurat $distribusiSurat) {
            return $user->id == $distribusiSurat->idTujuanDisposisi;
        });

        Gate::define('is-admin', function (User $user) {
            return $user->level == 'admin';
        });
    }
}
