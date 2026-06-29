<?php

namespace App\Libraries;

use Exception;
use Illuminate\Support\Facades\Http;

class ExchangeRate
{
    public string $baseUrl = '';

    public string $token = '';

    public function __construct()
    {
        $this->baseUrl = config('constants.exchange_rate.url');
        $this->token = config('constants.exchange_rate.token');
    }

    public function index(string $currency): array
    {
        try {
            $url = "{$this->baseUrl}/v6/{$this->token}/latest/{$currency}";

            $response = Http::get($url);
            $result = $response->json();

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
