<?php

namespace App\Libraries;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class Slack
{
    public static function send(string $message, string $channel = '')
    {
        $url = config('logging.channels.slack.url');

        $data = [
            'text' => $message,
            'username' => config('app.name'),
            'icon_url' => asset('images/favicon.png'),
        ];

        if ($channel) {
            $data['channel'] = App::isProduction() ? $channel : '#test';
        }

        if (App::isProduction()) {
            return Http::post($url, $data)?->json();
        }
    }
}
