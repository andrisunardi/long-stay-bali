<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (app()->isLocal()) {
            app()->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Model::shouldBeStrict();
        Model::preventLazyLoading();

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        LogViewer::auth(fn ($request) => optional($request->user())->hasRole('Admin') ?? false);

        Gate::before(function (User $user) {
            return $user->hasRole('Admin');
        });

        Gate::after(function (User $user) {
            return $user->hasRole('Admin');
        });

        Str::macro('idr', function ($value) {
            return 'IDR. '.number_format($value, 0, ',', '.');
        });

        Str::macro('successDanger', function ($value) {
            return $value == 1 ? 'success' : 'danger';
        });

        Str::macro('yesNo', function ($value) {
            return $value ? 'Yes' : 'No';
        });
    }
}
