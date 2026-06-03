<?php

namespace App\Providers;

use App\Models\User;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
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
            app()->register(IdeHelperServiceProvider::class);
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

        Str::macro('thousand', function ($value) {
            return number_format($value, 0, ',', '.');
        });

        Str::macro('idr', function ($value) {
            return 'IDR. '.number_format($value, 0, ',', '.');
        });

        Str::macro('abbreviate', function ($value) {
            $value = Str::replace('_', '', $value);
            $number = (int) $value;

            if ($number >= 1000) {
                $thousands = $number / 1000;
                $formatted = number_format($thousands, 0, ',', '.');

                return $formatted.'K';
            }

            return number_format($number, 0, ',', '.');
        });

        Str::macro('successDanger', function ($value) {
            return $value == 1 ? 'success' : 'danger';
        });

        Str::macro('yesNo', function ($value) {
            return $value ? trans('index.yes') : trans('index.no');
        });

        Str::macro('filesize', function ($bytes) {
            if (! $bytes) {
                return '-';
            }
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = floor(log($bytes, 1024));

            return round($bytes / pow(1024, $i), 2).' '.$units[$i];
        });
    }
}
