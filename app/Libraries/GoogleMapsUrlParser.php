<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class GoogleMapsUrlParser
{
    public static function parse(string $url): array
    {
        $finalUrl = static::resolveUrl($url);

        return [
            'url' => $finalUrl,
            'latitude' => static::extractLatitude($finalUrl),
            'longitude' => static::extractLongitude($finalUrl),
            'address' => static::extractAddress($finalUrl),
            'has_coordinates' => static::hasCoordinates($finalUrl),
        ];
    }

    public static function resolveUrl(string $url): string
    {
        try {
            $response = Http::withOptions([
                'allow_redirects' => true,
            ])->get($url);

            return $response->effectiveUri()?->__toString() ?? $url;
        } catch (\Throwable) {
            return $url;
        }
    }

    public static function hasCoordinates(string $url): bool
    {
        return static::extractLatitude($url) !== null
            && static::extractLongitude($url) !== null;
    }

    public static function extractLatitude(string $url): ?float
    {
        return static::extractCoordinates($url)['latitude'];
    }

    public static function extractLongitude(string $url): ?float
    {
        return static::extractCoordinates($url)['longitude'];
    }

    public static function extractCoordinates(string $url): array
    {
        /**
         * Format:
         * /@-8.6591661,115.1451081
         */
        if (preg_match(
            '/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/',
            $url,
            $matches
        )) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2],
            ];
        }

        /**
         * Format:
         * /search/-8.635304,+115.156736
         */
        if (preg_match(
            '/search\/(-?\d+(?:\.\d+)?),\+?(-?\d+(?:\.\d+)?)/',
            $url,
            $matches
        )) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2],
            ];
        }

        /**
         * Format:
         * !3d-8.6591094!4d115.1451081
         */
        if (
            preg_match('/!3d(-?\d+(?:\.\d+)?)/', $url, $lat) &&
            preg_match('/!4d(-?\d+(?:\.\d+)?)/', $url, $lng)
        ) {
            return [
                'latitude' => (float) $lat[1],
                'longitude' => (float) $lng[1],
            ];
        }

        return [
            'latitude' => null,
            'longitude' => null,
        ];
    }

    public static function extractAddress(string $url): ?string
    {
        /**
         * /place/Wabi+Sabi+Villa/
         */
        if (preg_match('/place\/([^\/]+)/', $url, $matches)) {
            return urldecode(
                str_replace('+', ' ', $matches[1])
            );
        }

        return null;
    }
}
