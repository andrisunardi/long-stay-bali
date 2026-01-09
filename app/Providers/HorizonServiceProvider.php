<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::routeSmsNotificationsTo(Config::get('constants.slack.sms'));
        Horizon::routeMailNotificationsTo(Config::get('constants.slack.mail'));
        Horizon::routeSlackNotificationsTo(Config::get('logging.channels.slack.url'), Config::get('constants.slack.channel'));
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', function (User $user) {
            return $user->hasRole('Admin');
        });
    }
}
