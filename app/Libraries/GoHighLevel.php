<?php

namespace App\Libraries;

use App\Models\Oauth;
use Exception;
use Illuminate\Support\Facades\Http;

class GoHighLevel
{
    public string $baseUrl = '';

    public function __construct()
    {
        $this->baseUrl = config('constants.ghl.url');
    }

    private function getHeader(): array
    {
        $oauth = Oauth::where('code', 'GOHIGHLEVEL')->firstOrFail();

        $header = [
            'Version' => config('constants.ghl.version'),
            'Authorization' => "Bearer {$oauth->access_token}",
        ];

        return $header;
    }

    public function getContacts(
        string $id = '',
        string $locationId = '',
        string $startAfterId = '',
        string $startAfter = '',
        string $query = '',
        ?int $limit = null,
    ): array {
        try {
            $url = "{$this->baseUrl}/contacts/{$id}";

            $locationId = $locationId ?: config('constants.ghl.location_id');

            $data = array_filter([
                'locationId' => $locationId,
                'startAfterId' => $startAfterId,
                'startAfter' => $startAfter,
                'query' => $query,
                'limit' => $limit,
            ]);

            $response = Http::withHeaders($this->getHeader())->get($url, $data);
            $result = $response->json();

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createContacts(array $data): array
    {
        try {
            $url = "{$this->baseUrl}/contacts";

            $locationId = $data['location_id'] ?? config('constants.ghl.location_id');

            $data = array_filter([
                'locationId' => $locationId,
                'firstName' => $data['first_name'] ?? null,
                'lastName' => $data['last_name'] ?? null,
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
            ]);

            $response = Http::withHeaders($this->getHeader())->post($url, $data);
            $result = $response->json();

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateContacts(string $id, array $data): array
    {
        try {
            $url = "{$this->baseUrl}/contacts/{$id}";

            $locationId = $data['location_id'] ?? config('constants.ghl.location_id');

            $data = array_filter([
                'locationId' => $locationId,
                'firstName' => $data['first_name'],
                'lastName' => $data['last_name'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
            ]);

            $response = Http::withHeaders($this->getHeader())->put($url, $data);
            $result = $response->json();

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function oauth(string $code): Oauth
    {
        $response = Http::asForm()->post(config('constants.ghl.oauth_url'), [
            'client_id' => config('constants.ghl.client_id'),
            'client_secret' => config('constants.ghl.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('constants.ghl.redirect_uri'),
            'user_type' => config('constants.ghl.user_type'),
        ]);

        $data = $response->json();

        if (isset($data['error'])) {
            abort(400);
        }

        $oauth = Oauth::firstOrCreate(['code' => 'GOHIGHLEVEL']);
        $oauth->refresh_token = $data['refresh_token'];
        $oauth->access_token = $data['access_token'];
        $oauth->token_type = $data['token_type'];
        $oauth->expires_in = $data['expires_in'];
        $oauth->scope = $data['scope'];
        $oauth->save();

        return $oauth;
    }

    public function refresh( ): Oauth
    {
        $oauth = Oauth::firstOrCreate(['code' => 'GOHIGHLEVEL']);

        $response = Http::asForm()->post(config('constants.ghl.oauth_url'), [
            'client_id' => config('constants.ghl.client_id'),
            'client_secret' => config('constants.ghl.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $oauth->refresh_token,
            'user_type' => config('constants.ghl.user_type'),
            'redirect_uri' => config('constants.ghl.redirect_uri'),
        ]);

        $data = $response->json();

        if (isset($data['error'])) {
            abort(400);
        }

        $oauth = Oauth::where('code', 'GOHIGHLEVEL')->firstOrFail();
        $oauth->refresh_token = $data['refresh_token'];
        $oauth->access_token = $data['access_token'];
        $oauth->token_type = $data['token_type'];
        $oauth->expires_in = $data['expires_in'];
        $oauth->scope = $data['scope'];
        $oauth->save();

        return $oauth;
    }
}
